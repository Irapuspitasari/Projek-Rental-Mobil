<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    // Payment Statuses
    const STATUS_PENDING = 'Pending';
    const STATUS_PAID = 'Paid';
    const STATUS_FAILED = 'Failed';
    const STATUS_EXPIRED = 'Expired';

    protected $fillable = [
        'booking_id',
        'slug',
        'method',
        'status',
        'amount',
        'payment_url',
        'payment_reference',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Helper Methods
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
