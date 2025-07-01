@extends('layouts1.app')

@section('content')
<section class="relative bg-[#060523]">
    <div class="container py-20">
        <div class="flex flex-col">
            <header class="mb-[50px] max-w-[360px] w-full">
                <h2 class="font-bold text-white text-[26px] mb-4">
                    Cek Data Booking
                </h2>
                <form action="{{ route('bookings.search') }}" method="GET" class="mb-5">
                    <div class="flex flex-col col-span-2 gap-3">
                        <label for="" class="text-base font-semibold text-white">
                            Kode/Nama Penyewa
                        </label>
                        <input type="text" name="search_term" id="search_term"
                            class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                            placeholder="kode booking atau nama penyewa"
                            value="{{ old('search_term', $search_term ?? '') }}">
                    </div>
                    <br>
                    <div class="flex flex-col col-span-2 gap-3">
                        <label for="" class="text-base font-semibold text-white">
                            Tanggal Mulai Sewa
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                            value="{{ old('start_date', $start_date ?? '') }}"><small style="color: white">Wajib di isi jika input nama penyewa</small>
                    </div>
                    <br>
                    <!-- Button Primary -->
                    <div class="p-1 rounded-full bg-primary group w-max mt-6">
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </form>
            </header>
        </div>
        <div class="absolute bottom-[-30px] right-0 lg:w-[764px] max-h-[332px] hidden lg:block">
            <img src="{{ asset('sewa/public/assets/images/porsche_small.webp') }}" alt="Porsche Car">
        </div>
    </div>
</section>
<section class="bg-darkGrey">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <header class="mb-[30px]">
                        <h2 class="font-bold text-dark text-[26px] mb-1" style="text-align: center; margin-top: 40px;">
                            Status Booking
                        </h2>
                        <hr style="border-top: 2px solid #000;">
                    </header>

                    <div class="card-body p-12">
                        <!-- Hasil Pencarian -->
                        @if(request()->hasAny(['search_term', 'start_date']))
                        @if($booking)
                        <!-- Header Hasil -->
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                                <div>
                                    <h5 class="mb-1 fw-bold">Data Ditemukan!</h5>
                                    <p class="mb-0">
                                        @if($is_slug_search)
                                        Kode booking: <strong>{{ $search_term }}</strong>
                                        @else
                                        Nama penyewa: <strong>{{ $search_term }}</strong>
                                        @if($start_date)
                                        pada tanggal <strong>{{ \Carbon\Carbon::parse($start_date)->format('d/m/Y')
                                            }}</strong>
                                        @endif
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <form action="" class="bg-white p-[30px] pb-10 rounded-3xl max-w-[490px] w-full">
                                <div class="flex flex-col gap-[30px]">
                                    <div class="flex flex-col gap-4">
                                        <h5 class="text-lg font-semibold">
                                            Review Order
                                        </h5>
                                        <!-- Items -->
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Nama Penyewa
                                            </p>
                                            <p class="text-base font-semibold" style="color: red">
                                                {{ $booking->name}}
                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Mobil
                                            </p>
                                            <p class="text-base font-semibold">
                                                {{ $booking->item->brand->name }} {{ $booking->item->name }}
                                            </p>
                                        </div>
                                        <!-- Items -->
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Durasi
                                            </p>
                                            <p class="text-base font-semibold">
                                                {{ $booking->duration_days }} hari
                                            </p>
                                        </div>
                                        <!-- Items -->
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Tanggal
                                            </p>
                                            <p class="text-base font-semibold">
                                                {{ $booking->start_date->format('d M Y') }} - {{
                                                $booking->end_date->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Daerah Sewa
                                            </p>
                                            <p class="text-base font-semibold">
                                                @if($booking->region == 'Jateng') Jawa Tengah
                                                @elseif($booking->region == 'DIY') DIY
                                                @else Luar Provinsi
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Driver
                                            </p>
                                            <p class="text-base font-semibold">
                                                {{ $booking->driver_option }}
                                            </p>
                                        </div>
                                        <hr>
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-semibold">
                                                Kode Booking
                                            </p>
                                            <p class="text-base font-semibold">
                                                {{ $booking->slug }}
                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-semibold">
                                                Status Booking
                                            </p>
                                            <p class="text-base font-semibold" style="@if($booking->status == 'Pending') color: orange; @elseif($booking->status == 'Confirmed') color: blue;
                                            @elseif($booking->status == 'On Rent') color: teal; @elseif($booking->status == 'Completed') color: green;
                                            @elseif($booking->status == 'Cancelled') color: red; @endif">
                                                {{ $booking->status }}
                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-semibold">
                                                Status Pembayaran
                                            </p>
                                            @if($booking->status == 'Confirmed' || $booking->status == 'On Rent' ||
                                            $booking->status ==
                                            'Completed')
                                            <p class="text-base font-semibold" style="@if(optional($booking->payment)->status == 'Paid') color: green;
                                                @else color: orange;
                                                @endif">
                                                {{ optional($booking->payment)->status ?? '-' }}
                                            </p>
                                            @else
                                            <p class="text-base font-semibold text-gray-400">-</p>
                                            @endif
                                        </div>
                                        <hr>
                                        <!-- Items -->
                                        <!-- Price -->
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Harga Dasar ({{ $booking->duration_days }} hari)
                                            </p>
                                            <p class="text-base font-semibold">
                                                Rp {{ number_format($booking->base_price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Driver Fee -->
                                        @if($booking->driver_fee > 0)
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Biaya Driver ({{ $booking->duration_days }} hari)
                                            </p>
                                            <p class="text-base font-semibold">
                                                Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        @endif

                                        <!-- Out of Region Fee -->
                                        @if($booking->out_of_region_fee > 0)
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal">
                                                Biaya Luar Provinsi
                                            </p>
                                            <p class="text-base font-semibold">
                                                Rp {{ number_format($booking->out_of_region_fee, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        @endif

                                        <!-- Overtime Fee -->
                                        @if($booking->overtime_fee > 0)
                                        <div class="flex items-center justify-between">
                                            <p class="text-base font-normal" style="color: red">
                                                Biaya Overtime
                                            </p>
                                            <p class="text-base font-semibold" style="color: red">
                                                Rp {{ number_format($booking->overtime_fee, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        @endif

                                        <!-- Total -->
                                        <div class="flex items-center justify-between font-bold mt-2 border-t pt-2">
                                            <p class="text-base">
                                                Total Harga
                                            </p>
                                            <p class="text-base">
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                    </div>
                                    <!-- CTA Button -->
                                    <div class="col-span-2 mt-5">
                                        @if($booking->payment && $booking->payment->status == 'Paid')
                                        <div
                                            class="p-4 bg-green-100 text-green-800 text-sm rounded-lg border border-green-300">
                                            <p class="font-semibold" style="color: green">
                                                Telah dibayar pada tanggal
                                                {{ $booking->payment->payment_date ?
                                                $booking->payment->payment_date->format('d M Y
                                                H:i') : '-' }}
                                            </p>
                                            <p class="font-semibold">
                                                Metode Pembayaran :
                                                {{ $booking->payment->method }}
                                            </p>
                                        </div>
                                        @else
                                        <!-- Button Primary -->
                                        <div class="p-1 rounded-full bg-primary group">
                                            <a href="{{ route('bookings.payment', $booking->slug) }}"
                                                class="btn-primary">
                                                <p>
                                                    Continue
                                                </p>
                                                <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                            </form>
                        </div>
                        @else
                        <!-- Tidak Ada Hasil -->
                        <div class="alert alert-danger border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3 text-danger"></i>
                                <div>
                                    <h5 class="mb-1 fw-bold">Data Tidak Ditemukan</h5>
                                    <p class="mb-3">
                                        Tidak ditemukan booking dengan:
                                        @if($is_slug_search)
                                        kode <strong>{{ $search_term }}</strong>
                                        @else
                                        nama <strong>{{ $search_term }}</strong>
                                        @if($start_date)
                                        pada tanggal <strong>{{ \Carbon\Carbon::parse($start_date)->format('d/m/Y')
                                            }}</strong>
                                        @endif
                                        @endif
                                    </p>
                                    <a href="{{ route('bookings.create') }}" class="btn btn-success">
                                        <i class="fas fa-plus me-2"></i>Buat Booking Baru
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
