<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PujaBookingRequest;
use App\Models\pooja;
use App\Models\PoojaBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PujaBookingController extends Controller
{
    // Standard temple daily time slots
    private array $defaultSlots = [
        '06:00 AM - 07:30 AM',
        '08:00 AM - 09:30 AM',
        '10:00 AM - 11:30 AM',
        '04:00 PM - 05:30 PM',
        '06:00 PM - 07:30 PM',
    ];

    private int $maxCapacityPerSlot = 1;

    /**
     * Fetch slot availability for a date
     */
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

    /**
     * First or Create User & Book Slot
     */
    public function bookPuja(PujaBookingRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Check concurrency / slot availability inside lock
            $existingCount = PoojaBooking::where('puja_id', $data['puja_id'])
                ->where('booking_date', $data['booking_date'])
                ->where('time_slot', $data['time_slot'])
                ->whereIn('payment_status', ['completed', 'pending'])
                ->lockForUpdate()
                ->count();

            if ($existingCount >= $this->maxCapacityPerSlot) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'The selected time slot is no longer available. Please choose another slot.',
                ], 422);
            }

            // Find existing user by mobile or auto-register new user
            $user = User::firstOrCreate(
                ['mobile' => $data['mobile']],
                [
                    'name' => $data['name'],
                    'dob' => $data['dob'] ?? null,
                    'source_type' => 'puja_booking',
                    'is_donor' => 0,
                    'password' => Hash::make(Str::random(10)),
                ]
            );

            // Fetch pricing details from poojas table
            $puja = pooja::findOrFail($data['puja_id']);
            $price = $puja->offer_price ?? $puja->price;

            // Create booking record
            $booking = PoojaBooking::create([
                'user_id' => $user->id,
                'puja_id' => $puja->id,
                'booking_date' => $data['booking_date'],
                'time_slot' => $data['time_slot'],
                'amount' => $price,
                'payment_status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Booking request submitted successfully.',
                'data' => [
                    'booking' => $booking->load(['user', 'puja']),
                    'is_new_user' => $user->wasRecentlyCreated,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to process booking.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
