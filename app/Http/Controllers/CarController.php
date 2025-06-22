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
        // Get popular items with their type, brand, and reviews
        $popularItems = Item::with(['type', 'brand', 'reviews'])
            ->withAvg('reviews', 'star')
            ->withCount('reviews')
            ->orderBy('reviews_avg_star', 'desc')
            // ->take(100)
            ->get();

        return view('car', compact('popularItems'));
    }
}
