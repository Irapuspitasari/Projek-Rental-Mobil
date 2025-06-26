@extends('layouts1.app')

@section('content')
<section class="bg-darkGrey relative py-[70px]">
    <div class="container">
        <header class="mb-[30px]">
            <h2 class="font-bold text-dark text-[26px] mb-1">
                Pembayaran untuk Booking # {{ $booking->name }}
            </h2>
            <p class="text-base text-secondary">Pilih metode Pembayaran</p>
        </header>

        <div class="flex items-center gap-5 lg:justify-between">
            <!-- Form Card -->
            <form action="{{ route('bookings.processPayment', $booking->slug) }}" method="POST"
                class="bg-white p-[30px] pb-10 rounded-3xl max-w-[490px] w-full">
                @csrf

                <div class="flex flex-col gap-[30px]">
                    <!-- ALERT ERROR -->
                    @if(session('error'))
                    <div class="w-full p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- RINCIAN HARGA -->
                    <div class="flex flex-col gap-4">
                        <h5 class="text-lg font-semibold">Rincian Harga</h5>

                        <div class="flex items-center justify-between">
                            <p class="text-base font-normal">Harga Dasar ({{ $booking->duration_days }} hari)</p>
                            <p class="text-base font-semibold">Rp {{ number_format($booking->base_price, 0, ',', '.') }}
                            </p>
                        </div>

                        @if($booking->driver_fee > 0)
                        <div class="flex items-center justify-between">
                            <p class="text-base font-normal">Biaya Driver ({{ $booking->duration_days }} hari)</p>
                            <p class="text-base font-semibold">Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}
                            </p>
                        </div>
                        @endif

                        @if($booking->out_of_region_fee > 0)
                        <div class="flex items-center justify-between">
                            <p class="text-base font-normal">Biaya Luar Provinsi</p>
                            <p class="text-base font-semibold">Rp {{ number_format($booking->out_of_region_fee, 0, ',',
                                '.') }}</p>
                        </div>
                        @endif

                        @if($booking->overtime_fee > 0)
                        <div class="flex items-center justify-between">
                            <p class="text-base font-normal text-red-500">Biaya Overtime</p>
                            <p class="text-base font-semibold text-red-500">Rp {{ number_format($booking->overtime_fee,
                                0, ',', '.') }}</p>
                        </div>
                        @endif

                        <div class="flex items-center justify-between font-bold mt-2 border-t pt-2">
                            <p class="text-base">Total Harga</p>
                            <p class="text-base">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- KONDISI SUDAH TERBAYAR -->
                    @if($booking->payment && $booking->payment->status == 'Paid')
                    <div
                        class="w-full p-4 bg-green-100 text-green-800 text-sm rounded-xl border border-green-300 text-center">
                        <p class="font-semibold">
                            Telah dibayar pada tanggal
                            {{ $booking->payment->payment_date ? $booking->payment->payment_date->format('d M Y H:i') :
                            '-' }}
                        </p>
                    </div>
                    @else
                    <!-- KONDISI PEMBAYARAN TERTUNDA -->
                    @if($booking->payment && $booking->payment->status === 'Pending' && $booking->payment->method ===
                    'Transfer')
                    <div class="p-4 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded-lg text-sm">
                        <p class="mb-2">Anda memiliki pembayaran transfer yang belum diselesaikan.</p>
                        <a href="{{ $booking->payment->payment_url }}"
                            class="inline-block px-4 py-2 bg-primary text-white rounded-lg font-semibold">
                            Lanjutkan Pembayaran
                        </a>
                    </div>
                    @else
                    <!-- FORM PEMBAYARAN -->
                    <div class="flex flex-col gap-4">
                        <h5 class="text-lg font-semibold">Metode Pembayaran</h5>
                        <div class="grid md:grid-cols-2 gap-4 md:gap-[30px] items-center">
                            <div class="relative boxPayment">
                                <input type="radio" value="Cash" name="method" id="cash"
                                    class="absolute inset-0 z-50 opacity-0 cursor-pointer" required>
                                <label for="cash"
                                    class="flex items-center justify-center gap-4 border border-grey rounded-[20px] p-5 min-h-[80px]">
                                    <img src="{{ asset('sewa/public/assets/svgs/cash-icon.svg') }}" alt=""
                                        width="50px;">
                                    <p class="text-base font-semibold">Cash</p>
                                </label>
                            </div>

                            <div class="relative boxPayment">
                                <input type="radio" value="Transfer" name="method" id="midtrans"
                                    class="absolute inset-0 z-50 opacity-0 cursor-pointer">
                                <label for="midtrans"
                                    class="flex items-center justify-center gap-4 border border-grey rounded-[20px] p-5 min-h-[80px]">
                                    <img src="{{ asset('sewa/public/assets/svgs/logo-midtrans.svg') }}" alt="">
                                    <p class="text-base font-semibold">Midtrans</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Input jumlah pembayaran (hidden) -->
                    <input type="hidden" name="amount" value="{{ $booking->total_price }}">

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col gap-4 mt-6">
                        <button type="submit" class="btn-primary w-full py-3">
                            Proses Pembayaran
                        </button>
                    </div>
                    @endif
                    @endif
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('bookings.show', $booking->slug) }}"
                            class="btn-secondary w-full py-3 text-center">
                            Kembali
                        </a>
                    </div>
                </div>
            </form>

            <img src="{{ asset('sewa/public/assets/images/porsche_small.webp') }}"
                class="max-w-[50%] hidden lg:block -mr-[100px]" alt="">
        </div>
    </div>
</section>
@endsection
