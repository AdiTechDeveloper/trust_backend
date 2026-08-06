<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Models\CommunityMember;
use App\Models\CommunityFamilyMember;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function join(CommunityRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {

            $member = CommunityMember::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'gender' => $data['gender'] ?? null,
                'dob' => $data['dob'] ?? null,
                'marital_status' => $data['marital_status'] ?? 'Single',
                'anniversary_date' => $data['anniversary_date'] ?? null,
                'designation' => $data['designation'] ?? null,
                'company_name' => $data['company_name'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'address' => $data['address'] ?? null,
                'status' => true,
            ]);

            if (!empty($data['family_members'])) {

                foreach ($data['family_members'] as $family) {

                    CommunityFamilyMember::create([

                        'community_member_id' => $member->id,

                        'name' => $family['name'],

                        'relation' => $family['relation'],

                        'dob' => $family['dob'],

                        'anniversary_date' => $family['anniversary_date'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Community member registered successfully.',
                'data' => $member->load('familyMembers'),
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

      public function index()
    {
        // Saare community members latest first fetch kar rahe hain
        $members = CommunityMember::latest()->get();

        return view('admin.community-member.index', compact('members'));
    }

     // Route Model Binding: Laravel khud CommunityMember::findOrFail($id) kar deta hai
    public function show(CommunityMember $communityMember)
    {
        // Family members bhi saath mein load kar rahe hain (eager loading)
        $communityMember->load('familyMembers');

        return view('admin.community-member.show', compact('communityMember'));
    }
}