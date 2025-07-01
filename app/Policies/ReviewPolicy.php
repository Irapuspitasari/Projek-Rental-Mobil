<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    public function create(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id
            && $booking->status === 'Completed'
            && !$booking->review()->exists();
    }
    public function update(User $user, Review $review)
    {
        return $user->id === $review->user_id
            && $review->booking->status === 'Completed'
            && $review->booking->canBeReviewed();
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id;
    }
}
