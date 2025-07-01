<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'booking_id',
        'star',
        'comment',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    protected static function booted()
    {
        static::creating(function ($review) {
            if (!$review->booking || $review->booking->status !== 'Completed') {
                throw ValidationException::withMessages([
                    'booking_id' => ['Hanya booking dengan status Completed yang bisa direview']
                ]);
            }
        });
    }
}
