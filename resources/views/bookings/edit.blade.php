@extends('layouts2.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Booking #{{ $booking->slug }}</h1>

    <form action="{{ route('bookings.update', $booking->slug) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Informasi Penyewa</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $booking->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ $booking->address }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ $booking->city }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="zip" name="zip" value="{{ $booking->zip }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Detail Penyewaan</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Pilih Item</label>
                            <select class="form-select" id="item_id" name="item_id" required>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $booking->item_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} - Rp {{ number_format($item->price, 0, ',', '.') }}/hari
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ $booking->start_date->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="{{ $booking->end_date->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Daerah Sewa</label>
                            <select class="form-select" id="region" name="region" required>
                                <option value="Jateng" {{ $booking->region == 'Jateng' ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="DIY" {{ $booking->region == 'DIY' ? 'selected' : '' }}>Daerah Istimewa Yogyakarta</option>
                                <option value="Luar Provinsi" {{ $booking->region == 'Luar Provinsi' ? 'selected' : '' }}>Luar Provinsi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Opsi Driver</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="driver_option" id="with_driver"
                                    value="With Driver" {{ $booking->driver_option == 'With Driver' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="with_driver">Dengan Driver</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="driver_option" id="without_driver"
                                    value="Without Driver" {{ $booking->driver_option == 'Without Driver' ? 'checked' : '' }}>
                                <label class="form-check-label" for="without_driver">Tanpa Driver</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2">{{ $booking->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('bookings.show', $booking->slug) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
