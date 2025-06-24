@extends('layouts2.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pembayaran untuk Booking #{{ $booking->slug }}</div>

                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="mb-4">
                        <h5>Rincian Harga</h5>
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
                                <td class="text-end">Rp {{ number_format($booking->out_of_region_fee, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endif
                            <tr class="fw-bold">
                                <th>Total Harga</th>
                                <td class="text-end">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <form action="{{ route('bookings.processPayment', $booking->slug) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="method" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="method" name="method" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Cash">Tunai</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah Pembayaran</label>
                            <input type="number" class="form-control" id="amount" name="amount"
                                min="{{ $booking->total_price }}" value="{{ $booking->total_price }}" required>
                            <small class="text-muted">Minimal pembayaran: Rp {{ number_format($booking->total_price, 0,
                                ',', '.') }}</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bookings.show', $booking->slug) }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
                        </div>
                    </form>
                    @if($booking->payment)
                    @if($booking->payment->status === 'Pending' && $booking->payment->method === 'Transfer')
                    <div class="alert alert-info">
                        <p>Anda memiliki pembayaran transfer yang belum diselesaikan.</p>
                        <a href="{{ $booking->payment->payment_url }}" class="btn btn-primary">Lanjutkan Pembayaran</a>
                    </div>
                    @endif
                    @endif

                    <!-- Existing form -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
