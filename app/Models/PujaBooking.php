<?php

namespace App\Models;
use App\Models\pooja;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PujaBooking extends Model
{
    //

    protected $table = 'pooja_bookings';

    protected $fillable = [
        'user_id',
        'puja_id',
        'booking_date',
        'time_slot',
        'amonut',
        'payment_status',
        'transaction_id',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user(){
        return $this->belongsTo(User::class);

    }

    public function puja(){
        return $this->belongsTo(Pooja::class,'puja_id');
    }
    
}
