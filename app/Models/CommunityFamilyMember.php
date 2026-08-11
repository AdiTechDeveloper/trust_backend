<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityFamilyMember extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'dob',
        'anniversary_date',
    ];

    protected $casts = [
        'dob' => 'date',
        'anniversary_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function communityMember()
    {
        return $this->belongsTo(CommunityMember::class, 'community_member_id');
    }
}
