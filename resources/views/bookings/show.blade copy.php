@extends('layouts2.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Booking #{{ $booking->slug }}</h1>

        <div>
            @if($booking->status == 'Pending')
                <a href="{{ route('bookings.edit', $booking->slug) }}" class="btn btn-warning">Edit</a>
            @endif

            {{-- @if(auth()->user()->is_admin) --}}
                @if($booking->status == 'Pending')
                    <form action="{{ route('bookings.confirm', $booking->slug) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </form>
                @elseif($booking->status == 'Confirmed' && $booking->is_paid)
                    <form action="{{ route('bookings.markAsOnRent', $booking->slug) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info">Mulai Sewa</button>
                    </form>
                @elseif($booking->status == 'On Rent')
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeModal">Selesaikan</button>
                @endif
            {{-- @endif --}}

            @if(in_array($booking->status, ['Pending', 'Confirmed']))
                <form action="{{ route('bookings.cancel', $booking->slug) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Batalkan</button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Informasi Penyewa</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $booking->name }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $booking->address }}</td>
                        </tr>
                        <tr>
                            <th>Kota</th>
                            <td>{{ $booking->city }}</td>
                        </tr>
                        <tr>
                            <th>Kode Pos</th>
                            <td>{{ $booking->zip ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Detail Pembayaran</div>
                <div class="card-body">
                    @if($booking->payment)
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Metode Pembayaran</th>
                                <td>{{ $booking->payment->method }}</td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    <span class="badge bg-{{ $booking->payment->status == 'Paid' ? 'success' : 'warning' }}">
                                        {{ $booking->payment->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Dibayar</th>
                                <td>Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</td>
                            </tr>
                            @if($booking->payment->payment_date)
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>{{ $booking->payment->payment_date->format('d M Y H:i') }}</td>
                                </tr>
                            @endif
                        </table>
                    @else
                        <p>Belum ada informasi pembayaran.</p>
                        @if($booking->status == 'Pending' || $booking->status == 'Confirmed')
                            <a href="{{ route('bookings.payment', $booking->slug) }}" class="btn btn-primary">Bayar Sekarang</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Detail Penyewaan</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Item</th>
                            <td>{{ $booking->item->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>{{ $booking->start_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ $booking->end_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $booking->duration_days }} hari</td>
                        </tr>
                        <tr>
                            <th>Daerah Sewa</th>
                            <td>
                                @if($booking->region == 'Jateng') Jawa Tengah
                                @elseif($booking->region == 'DIY') DIY
                                @else Luar Provinsi
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Driver</th>
                            <td>{{ $booking->driver_option }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge
                                    @if($booking->status == 'Pending') bg-warning text-dark
                                    @elseif($booking->status == 'Confirmed') bg-primary
                                    @elseif($booking->status == 'On Rent') bg-info
                                    @elseif($booking->status == 'Completed') bg-success
                                    @elseif($booking->status == 'Cancelled') bg-danger
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @if($booking->notes)
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $booking->notes }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Rincian Harga</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="60%">Harga Dasar ({{ $booking->duration_days }} hari)</th>
                            <td class="text-end">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</td>
                        </tr>
                        @if($booking->driver_fee > 0)
                            <tr>
                                <th>Biaya Driver ({{ $booking->duration_days }} hari)</th>
                                <td class="text-end">Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if($booking->out_of_region_fee > 0)
                            <tr>
                                <th>Biaya Luar Provinsi</th>
                                <td class="text-end">Rp {{ number_format($booking->out_of_region_fee, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if($booking->overtime_fee > 0)
                            <tr>
                                <th>Biaya Overtime</th>
                                <td class="text-end">Rp {{ number_format($booking->overtime_fee, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        <tr class="fw-bold">
                            <th>Total Harga</th>
                            <td class="text-end">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- @if($booking->status == 'On Rent')
        <!-- Complete Booking Modal -->
        <div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('bookings.markAsCompleted', $booking->slug) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="completeModalLabel">Selesaikan Penyewaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="actual_end_date" class="form-label">Tanggal Pengembalian Aktual</label>
                                <input type="datetime-local" class="form-control" id="actual_end_date" name="actual_end_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Selesaikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif --}}
</div>
@endsection
