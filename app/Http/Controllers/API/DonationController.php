<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use App\Services\ReceiptService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class DonationController extends Controller
{
    public function __construct(
        private ReceiptService $receiptService
    ) {}

    private function getRazorpayApi(): Api
    {
        $key = config('services.razorpay.key') ?? env('RAZORPAY_KEY');
        $secret = config('services.razorpay.secret') ?? env('RAZORPAY_SECRET');

        if (! $key || ! $secret) {
            throw new Exception('Razorpay credentials missing from server configuration.');
        }

        return new Api($key, $secret);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'category_id' => 'nullable|string',
        ]);

        $amountInPaise = (int) round((float) $request->amount * 100);

        try {
            $api = $this->getRazorpayApi();
            $orderData = [
                'receipt' => 'rcpt_don_'.time(),
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'payment_capture' => 1,
            ];

            $razorpayOrder = $api->order->create($orderData);

            return response()->json([
                'status' => true,
                'message' => 'Donation Razorpay order created.',
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $orderData['amount'],
                'currency' => 'INR',
                'key' => config('services.razorpay.key') ?? env('RAZORPAY_KEY'),
            ], 200);

        } catch (Exception $e) {
            Log::error('Donation Order Creation Failed: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to initialize payment gateway.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyPaymentAndDonate(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'category_id' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'name' => 'required|string',
            'dob' => 'required|date',
            'pan' => 'nullable|string',
            'anonymous' => 'boolean',
            'recurring' => 'boolean',
            'wants80G' => 'boolean',
        ]);

        // Verify Payment Signature First
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
                'message' => 'Payment signature verification failed.',
                'error' => $e->getMessage(),
            ], 400);
        }

        // Perform DB operations inside a Transaction
        DB::beginTransaction();

        try {
            $user = User::where('email', $request->email)
                ->orWhere('mobile', $request->phone)
                ->first();

            if (! $user) {
                $user = User::create([
                    'email' => $request->email,
                    'mobile' => $request->phone,
                    'name' => $request->name ?? 'Donor',
                    'dob' => $request->dob,
                    'source_type' => 'donation',
                    'is_donor' => 1,
                    'password' => Hash::make(Str::random(10)),
                ]);
            } else {
                if (! $user->is_donor) {
                    $user->update(['is_donor' => 1]);
                }
            }

            // Create Donation Record
            $donation = Donation::create([
                'user_id' => $user->id,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'pan_number' => $request->wants80G ? $request->pan : null,
                'is_anonymous' => $request->anonymous ?? false,
                'is_recurring' => $request->recurring ?? false,
                'wants_80g' => $request->wants80G ?? true,
                'payment_status' => 'completed',
            ]);

            DB::commit();

            try {
                $this->receiptService->generate($donation);
            } catch (Exception $e) {
                Log::error('Receipt Generation Failed for Donation #'.$donation->id.': '.$e->getMessage());
            }

            return response()->json([
                'status' => true,
                'message' => 'Payment verified and donation recorded successfully.',
                'data' => [
                    'donation' => $donation,
                    'user' => $user,
                    'is_new_user' => $user->wasRecentlyCreated,
                ],
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Donation Record Storage Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Payment completed but failed to record donation details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
