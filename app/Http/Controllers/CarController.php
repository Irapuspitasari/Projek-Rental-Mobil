<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        // Get popular items with their type, brand, and reviews
        $popularItems = Item::with(['type', 'brand', 'reviews'])
            ->withAvg('reviews', 'star')
            ->withCount('reviews')
            ->orderBy('reviews_avg_star', 'desc')
            // ->take(100)
            ->get();

        return view('welcome', compact('popularItems'));
    }
    public function car()
    {
        $availableItems = Item::with(['type', 'brand', 'reviews'])
            ->withAvg('reviews', 'star')
            ->withCount('reviews')
            ->where('available', true)
            ->orderBy('reviews_avg_star', 'desc')
            ->get();
        $unavailableItems = Item::with(['type', 'brand', 'reviews'])
            ->withAvg('reviews', 'star')
            ->withCount('reviews')
            ->where('available', false)
            ->orderBy('reviews_avg_star', 'desc')
            ->get();

        return view('car', compact('availableItems', 'unavailableItems'));
    }
}
