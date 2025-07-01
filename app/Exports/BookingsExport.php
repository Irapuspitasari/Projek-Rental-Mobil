<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $status;

    public function __construct($startDate, $endDate, $status)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    public function collection()
    {
        return Booking::with(['item', 'payment'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Booking',
            // 'Tanggal Booking',
            'Nama Customer',
            'Item',
            'Tipe Driver',
            'Region',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Durasi (hari)',
            'Status Booking',
            'Total Harga',
            'Metode Pembayaran',
            'Status Pembayaran',
            'Tanggal Pembayaran'
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->slug,
            // $booking->created_at->format('d/m/Y'),
            $booking->name,
            $booking->item->name,
            $booking->driver_option,
            $booking->region,
            $booking->start_date ? $booking->start_date->format('d/m/Y') : '-',
            $booking->end_date ? $booking->end_date->format('d/m/Y') : '-',
            $booking->duration_days,
            $booking->status,
            'Rp ' . number_format($booking->total_price, 0, ',', '.'),
            $booking->payment ? $booking->payment->method : '-',
            $booking->payment ? $booking->payment->status : '-',
            $booking->payment && $booking->payment->payment_date
                ? $booking->payment->payment_date->format('d/m/Y')
                : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:N' => ['autoSize' => true],
            'A' => ['width' => 60],
            'B' => ['width' => 60],
            'C' => ['width' => 60],
            'D' => ['width' => 60],
            'E' => ['width' => 60],
            'F' => ['width' => 60],
            'G' => ['width' => 60],
            'H' => ['width' => 60],
            'I' => ['width' => 60],
            'J' => ['width' => 60],
            'K' => ['width' => 60],
            'L' => ['width' => 60],
            'M' => ['width' => 60],
            'N' => ['width' => 60],
        ];
    }
}
