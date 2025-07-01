<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Exports\BookingsExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default ke bulan berjalan
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        // Hitung tanggal awal dan akhir bulan
        $startDate = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $endDate = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();

        $status = $request->input('status');

        $bookings = Booking::with(['item', 'user', 'payment'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Generate bulan dan tahun untuk dropdown
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->format('F');
        }

        $years = range(Carbon::now()->year, Carbon::now()->subYears(5)->year);

        return view('reports.bookings', compact(
            'bookings',
            'startDate',
            'endDate',
            'status',
            'currentMonth',
            'currentYear',
            'months',
            'years'
        ));
    }

    public function export(Request $request)
    {
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $endDate = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        $status = $request->input('status');

        $fileName = 'laporan-booking-' . Carbon::create($currentYear, $currentMonth, 1)->format('F-Y') . '.xlsx';

        return Excel::download(
            new BookingsExport($startDate, $endDate, $status),
            $fileName
        );
    }
}
