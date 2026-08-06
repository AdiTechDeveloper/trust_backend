<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'user_id',
        'membership_no',
        'membership_type',
        'issue_date',
        'expiry_date',
        'status',
        'approved_id',
        'approved_at',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_id');
    }
}
