<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // 👇 Ye add karo
    protected $casts = [
        'dob' => 'date',
        'anniversary_date' => 'date',
        'status' => 'boolean',
    ];

    public function familyMembers(): HasMany
    {
        return $this->hasMany(CommunityFamilyMember::class);
    }
}