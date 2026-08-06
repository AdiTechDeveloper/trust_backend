<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityFamilyMember extends Model
{
    protected $fillable = [
        'community_member_id',
        'name',
        'relation',
        'dob',
        'anniversary_date',
    ];
     // 👇 Ye add karo
    protected $casts = [
        'dob' => 'date',
        'anniversary_date' => 'date',
        
    ];

    public function communityMember()
    {
        return $this->belongsTo(
            CommunityMember::class,
            'community_member_id'
        );
    }
}