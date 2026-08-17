<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PujaBookingRequest;
use App\Models\pooja;
use App\Models\PoojaBooking;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class PujaBookingController extends Controller
{
    private array $defaultSlots = [
        '06:00 AM - 07:30 AM',
        '08:00 AM - 09:30 AM',
        '10:00 AM - 11:30 AM',
        '04:00 PM - 05:30 PM',
        '06:00 PM - 07:30 PM',
    ];

    private int $maxCapacityPerSlot = 1;

    private function getRazorpayApi(): Api
    {
        $key = config('services.razorpay.key') ?? env('RAZORPAY_KEY');
        $secret = config('services.razorpay.secret') ?? env('RAZORPAY_SECRET');

        if (! $key || ! $secret) {
            throw new Exception('Razorpay credentials (RAZORPAY_KEY / RAZORPAY_SECRET) are missing from configuration.');
        }

        return new Api($key, $secret);
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'puja_id' => 'required|exists:poojas,id',
            'booking_date' => 'required|date',
        ]);

        $bookedSlots = PoojaBooking::where('puja_id', $request->puja_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('payment_status', ['completed', 'pending'])
            ->select('time_slot', DB::raw('count(*) as total'))
            ->groupBy('time_slot')
            ->pluck('total', 'time_slot')
            ->toArray();

        $slots = array_map(function ($slot) use ($bookedSlots) {
            $bookedCount = $bookedSlots[$slot] ?? 0;

            return [
                'time' => $slot,
                'available' => $bookedCount < $this->maxCapacityPerSlot,
                'remaining' => max(0, $this->maxCapacityPerSlot - $bookedCount),
            ];
        }, $this->defaultSlots);

        return response()->json([
            'status' => true,
            'slots' => $slots,
        ]);
    }

    public function createOrder(PujaBookingRequest $request)
    {
        $data = $request->validated();

        $existingCount = PoojaBooking::where('puja_id', $data['puja_id'])
            ->where('booking_date', $data['booking_date'])
            ->where('time_slot', $data['time_slot'])
            ->whereIn('payment_status', ['completed', 'pending'])
            ->count();

        if ($existingCount >= $this->maxCapacityPerSlot) {
            return response()->json([
                'status' => false,
                'message' => 'The selected time slot is no longer available. Please choose another slot.',
            ], 422);
        }

        $puja = pooja::findOrFail($data['puja_id']);

        // Ensure proper numerical casting for Razorpay (convert to paise)
        $rawAmount = $puja->offer_price ?? $puja->price;
        $amountInPaise = (int) round((float) $rawAmount * 100);

        if ($amountInPaise <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid puja price configured.',
            ], 422);
        }

        try {
            $api = $this->getRazorpayApi();
            $orderData = [
                'receipt' => 'rcpt_puja_'.time(),
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'payment_capture' => 1,
            ];

            $razorpayOrder = $api->order->create($orderData);

            return response()->json([
                'status' => true,
                'message' => 'Razorpay order created successfully.',
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $orderData['amount'],
                'currency' => 'INR',
                'key' => config('services.razorpay.key') ?? env('RAZORPAY_KEY'),
            ]);

        } catch (Exception $e) {
            Log::error('Razorpay Order Creation Failed: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to initialize payment gateway.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyPaymentAndBook(PujaBookingRequest $request)
    {
        $data = $request->validated();

        try {
            $api = $this->getRazorpayApi();
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Payment verification failed. Booking cancelled.',
                'error' => $e->getMessage(),
            ], 400);
        }

        DB::beginTransaction();

        try {
            $existingCount = PoojaBooking::where('puja_id', $request->puja_id)
                ->where('booking_date', $request->booking_date)
                ->where('time_slot', $request->time_slot)
                ->whereIn('payment_status', ['completed', 'pending'])
                ->lockForUpdate()
                ->count();

            if ($existingCount >= $this->maxCapacityPerSlot) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Slot was taken right before payment. Please contact support for a refund.',
                ], 422);
            }

            $user = User::firstOrCreate(
                ['mobile' => $request->mobile],
                [
                    'name' => $request->name,
                    'dob' => $request->dob,
                    'source_type' => 'puja_booking',
                    'is_donor' => 0,
                    'password' => Hash::make(Str::random(10)),
                ]
            );

            $puja = pooja::findOrFail($request->puja_id);
            $amountPaid = $puja->offer_price ?? $puja->price;

            $booking = PoojaBooking::create([
                'user_id' => $user->id,
                'puja_id' => $puja->id,
                'booking_date' => $request->booking_date,
                'time_slot' => $request->time_slot,
                'amount' => $amountPaid,
                'payment_status' => 'completed',
                'transaction_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment verified and Puja booked successfully.',
                'data' => [
                    'booking' => $booking->load(['user', 'puja']),
                    'is_new_user' => $user->wasRecentlyCreated,
                ],
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Puja Booking DB Storage Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Payment succeeded, but failed to record booking.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
