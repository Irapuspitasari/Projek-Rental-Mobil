<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'type_id',
        'brand_id',
        'photos',
        'features',
        'price',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // Relasi belongs-to: Item milik satu type
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('star') ?: 0;
    }

    public function reviewsCount()
    {
        return $this->reviews()->count();
    }
    public function hasUserReview($userId)
    {
        return $this->reviews()->where('user_id', $userId)->exists();
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
