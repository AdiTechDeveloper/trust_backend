<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoojaBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'puja_id',
        'booking_date',
        'time_slot',
        'amount',
        'payment_status',
        'transaction_id',
        'razorpay_order_id',
        'razorpay_payment_id',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user that made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the puja associated with the booking.
     */
    public function puja(): BelongsTo
    {
        return $this->belongsTo(pooja::class, 'puja_id');
    }
}
