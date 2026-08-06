<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function update(ProfileRequest $request){

        $data = $request->validated();

    
        $user = auth()->user();


        $user->update([
            'marital_status'=>$data['marital_status'],
            'dob' =>$data['dob'],
            'anniversary_date' =>$data['anniversary_date'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' =>$data['state'],
            'pincode' =>$data['pincode'],
         ]);

         return response()->json([
            'status' => true,
            'message' =>'Profile Updated Successfully.',
            'data' => $user
         ],200);

    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' =>'Profile Fetched successfuly',
            'data'=>$request->user(),
        ],200);
    }
}
