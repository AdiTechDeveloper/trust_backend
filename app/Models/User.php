<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'gender',
        'marital_status',
        'dob',
        'anniversary_date',
        'address',
        'city',
        'state',
        'pincode',
        'status',
        'role',
        'profile_photo',
        'password',
        'designation',
        'company_name',
        'source_type',
        'is_donor',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dob' => 'date',
            'anniversary_date' => 'date',
            'status' => 'boolean',
            'is_donor' => 'boolean',
        ];
    }

    public function familyMembers()
    {
        return $this->hasMany(CommunityFamilyMember::class, 'user_id');
    }
}
