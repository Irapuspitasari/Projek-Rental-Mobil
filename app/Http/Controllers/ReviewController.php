<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review
     */
    // public function store(Request $request, Item $item)
    // {
    //     $validated = $request->validate([
    //         'star' => 'required|integer|between:1,5',
    //         'comment' => 'required|string|max:500',
    //     ]);

    //     try {
    //         // Check for existing review using firstOrNew to prevent duplicates
    //         $review = Review::firstOrNew([
    //             'user_id' => Auth::id(),
    //             'item_id' => $item->id
    //         ]);

    //         if ($review->exists) {
    //             return back()
    //                 ->with('error', 'Anda sudah memberikan review untuk item ini.')
    //                 ->withInput();
    //         }

    //         $review->fill([
    //             'star' => $validated['star'],
    //             'comment' => $validated['comment']
    //         ])->save();

    //         // Update item rating cache
    //         $this->updateItemRating($item);

    //         return back()
    //             ->with('success', 'Review berhasil ditambahkan.');

    //     } catch (\Exception $e) {
    //         Log::error('Review store error: ' . $e->getMessage());
    //         return back()
    //             ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
    //             ->withInput();
    //     }
    // }
    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'star' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500',
            'booking_id' => 'required|exists:bookings,id'
        ]);
        try {
            $booking = Booking::where('id', $validated['booking_id'])
                ->where('user_id', Auth::id())
                ->where('status', 'Completed')
                ->firstOrFail();
            if ($booking->review) {
                return back()
                    ->with('error', 'Anda sudah memberikan review untuk booking ini.')
                    ->withInput();
            }
            $review = Review::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'booking_id' => $booking->id,
                'star' => $validated['star'],
                'comment' => $validated['comment']
            ]);
            $this->updateItemRating($item);
            return back()
                ->with('success', 'Review berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Review store error: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal menambahkan review. Pastikan booking sudah completed.')
                ->withInput();
        }
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'star' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500',
        ]);

        try {
            $review->update($validated);

            // Update item rating cache
            $this->updateItemRating($review->item);

            return back()
                ->with('success', 'Review berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Review update error: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui review.')
                ->withInput();
        }
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        try {
            $item = $review->item;
            $review->delete();

            // Update item rating cache
            $this->updateItemRating($item);

            return back()
                ->with('success', 'Review berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Review delete error: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus review.');
        }
    }

    /**
     * Update item rating cache
     */
    protected function updateItemRating(Item $item)
    {
        $item->update([
            'rating_cache' => $item->reviews()->avg('star'),
            'review_count' => $item->reviews()->count()
        ]);
    }
}
