<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipApprovalRequest;
use App\Http\Requests\MembershipRequest;
use App\Models\Membership;

class MembershipController extends Controller
{
    //
    public function apply(MembershipRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        // check user login
        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        // check profile completion
        if (
            empty($user->marital_status) ||
            empty($user->dob) ||
            empty($user->address) ||
            empty($user->city) ||
            empty($user->state) ||
            empty($user->pincode)
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Please complete your profile before applying for membership',
            ], 422);
        }

        // married user must have anniversary date
        if (
            $user->marital_status === 'Married' &&
            empty($user->anniversary_date)
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Please add your anniversary date.',
            ], 422);
        }

        // Duplicate membership check
        $exists = Membership::where('user_id', $user->id)->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Membership already exists for this user',
            ], 409);
        }

        // create membership
        $membership = Membership::create([
            'user_id' => $user->id,
            'membership_type' => $data['membership_type'],
            'membership_no' => null,
            'issue_date' => null,
            'expiry_date' => null,
            'status' => 'Pending',
            'approved_id' => null,
            'approved_at' => null,
            'remarks' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Membership request submitted successfully.',
            'data' => $membership,
        ], 201);
    }

    public function approve(MembershipApprovalRequest $request, $id)
    {
        // Admin check
        $data = $request->validated();
        $user = auth()->user();

             // Admin Authorization
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized Access.',
            ], 403);
        }

        // Find membership
        $membership = Membership::findOrFail($id);

        // Already Approved
        if ($membership->status === 'Approved') {
            return response()->json([
                'status' => false,  
                'message' => 'Membership already Rejected.',
            ], 409);
        }

        if ($membership->status === 'Rejected') {
            return response()->json([
                'status' => false,
                'message' => 'Membership already rejected. ',
            ], 409);
        }

        $membershipNo = 'TRUST-'.date('Y').'-'.str_pad($membership->id, 5, '0', STR_PAD_LEFT);

        $issueDate = now();
        $expiryDate = now()->addYear();

        $membership->update([
            'membership_no' => $membershipNo,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'status' => $data['status'],
            'approved_id' => $user->id,
            'approved_at' => now(),
            'remarks' => $data['remarks'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Membership approved successfully.',
            'data' => $membership,
        ], 200);
    }

    public function index()
    {
        $user  = auth()->user();

        if($user->role !== 'admin'){
            return response()->json()([
                'status' => false,
                'message' =>'Unauthorized Access.'
            ],403);
        }

        $membership = Membership::with('user')->get();

        return response()->json([
            'status' => true,
            'message' => 'Membership list fetched successfully.',
            'data' => $membership
        ],200);
    }
}
