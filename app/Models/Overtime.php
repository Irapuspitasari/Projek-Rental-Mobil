<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'hours',
        'fee_per_hour',
        'total_fee',
        'description'
    ];

    protected $casts = [
        'fee_per_hour' => 'decimal:2',
        'total_fee' => 'decimal:2'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($overtime) {
            $overtime->total_fee = $overtime->hours * $overtime->fee_per_hour;
        });
    }
}
