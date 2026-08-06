<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'gender',
        'dob',
        'marital_status',
        'anniversary_date',
        'designation',
        'company_name',
        'city',
        'state',
        'address',
        'status',
    ];

    public function familyMembers()
    {
        return $this->hasMany(
            CommunityFamilyMember::class,
            'community_member_id'
        );
    }
}