@extends('layouts2.app')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-4"> <i class="fas fa-receipt me-2"></i>Laporan Booking</h4>
            <div class="row align-items-center">
                <div class="col-md-3">
                    <form method="GET" class="form-inline">
                        <div class="form-group w-100">
                            <label for="month" class="mr-2">Bulan:</label>
                            <select name="month" id="month" class="form-control">
                                @foreach($months as $key => $month)
                                <option value="{{ $key }}" {{ $currentMonth==$key ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group w-100">
                        <label for="year" class="mr-2">Tahun:</label>
                        <select name="year" id="year" class="form-control">
                            @foreach($years as $year)
                            <option value="{{ $year }}" {{ $currentYear==$year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group w-100">
                        <label for="status" class="mr-2">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua</option>
                            <option value="Pending" {{ request('status')=='Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Confirmed" {{ request('status')=='Confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="On Rent" {{ request('status')=='On Rent' ? 'selected' : '' }}>On Rent
                            </option>
                            <option value="Completed" {{ request('status')=='Completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="Cancelled" {{ request('status')=='Cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end" style="margin-top: 20px">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <a href="{{ route('reports.export', request()->query()) }}" class="btn btn-success w-100">
                        <i class="fas fa-file-excel"></i>&nbsp; Export Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                Menampilkan data dari <strong>{{ $startDate->format('d F Y') }}</strong>
                sampai <strong>{{ $endDate->format('d F Y') }}</strong>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Booking</th>
                            <th>Customer</th>
                            <th>Mobil</th>
                            <th>Driver</th>
                            <th>Region</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->slug }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->item->name }}</td>
                            <td>{{ $booking->driver_option }}</td>
                            <td>{{ $booking->region }}</td>
                            <td>{{ $booking->start_date ? $booking->start_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $booking->end_date ? $booking->end_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $booking->duration_days }} hari</td>
                            <td>
                                <span class="badge
                                    @if($booking->status == 'Completed') badge-success
                                    @elseif($booking->status == 'Cancelled') badge-danger
                                    @elseif($booking->status == 'Confirmed') badge-primary
                                    @elseif($booking->status == 'On Rent') badge-warning
                                    @else badge-secondary
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td>{{ $booking->payment ? $booking->payment->method : '-' }}</td>
                            <td>
                                @if($booking->payment)
                                <span class="badge
                                        @if($booking->payment->status == 'Paid') badge-success
                                        @elseif($booking->payment->status == 'Failed') badge-danger
                                        @elseif($booking->payment->status == 'Expired') badge-secondary
                                        @else badge-warning
                                        @endif">
                                    {{ $booking->payment->status }}
                                </span>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center">Tidak ada data booking</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
