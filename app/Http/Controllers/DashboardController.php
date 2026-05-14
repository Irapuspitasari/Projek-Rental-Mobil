<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'Admin') {
            return redirect('/');
        }

        $totalUsers = User::count();
        $totalCars = Item::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'Completed')->sum('total_price');

        $recentBookings = Booking::with(['user', 'item'])
            ->latest()
            ->limit(5)
            ->get();

        // Data for revenue chart (last 6 months)
        $months = [];
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;
            
            $revenue = Booking::where('status', 'Completed')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->sum('total_price');
            
            $revenueData[] = $revenue;
        }

        $chartData = [
            'labels' => $months,
            'data' => $revenueData,
        ];

        // Booking Status counts
        $statusCounts = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $topCars = Item::withCount('reviews')
            ->withAvg('reviews', 'star')
            ->orderByDesc('reviews_avg_star')
            ->orderByDesc('reviews_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalCars',
            'totalBookings',
            'totalRevenue',
            'recentBookings',
            'chartData',
            'statusCounts',
            'topCars'
        ));
    }
}
