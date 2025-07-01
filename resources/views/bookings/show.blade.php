@extends('layouts1.app')

@section('content')
<section class="bg-darkGrey relative py-[70px]">
    <div class="container">
        <header class="mb-[30px]">
            <h2 class="font-bold text-dark text-[26px] mb-1">
                Checkout & Drive Faster
            </h2>
            <p class="text-base text-secondary">We will help you get ready today</p>
        </header>

        <div class="flex items-center gap-5 lg:justify-between">
            <!-- Form Card -->
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
                                {{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}
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
                            @if($booking->status == 'Confirmed' || $booking->status == 'On Rent' || $booking->status ==
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
                    {{-- <div class="flex flex-col gap-4">
                        <h5 class="text-lg font-semibold">
                            Payment Method
                        </h5>
                        <div class="grid md:grid-cols-2 gap-4 md:gap-[30px] items-center">
                            <div class="relative boxPayment">
                                <input type="radio" value="mastercard" name="paymentMethod" id="mastercard"
                                    class="absolute inset-0 z-50 opacity-0 cursor-pointer">
                                <label for="mastercard"
                                    class="flex items-center justify-center gap-4 border border-grey rounded-[20px] p-5 min-h-[80px]">
                                    <img src="{{ asset('sewa/public/assets/svgs/cash-icon.svg') }}" alt=""
                                        width="50px;">
                                    <p class="text-base font-semibold">
                                        Cash
                                    </p>
                                </label>
                            </div>
                            <div class="relative boxPayment">
                                <input type="radio" value="midtrans" name="paymentMethod" id="midtrans"
                                    class="absolute inset-0 z-50 opacity-0 cursor-pointer">
                                <label for="midtrans"
                                    class="flex items-center justify-center gap-4 border border-grey rounded-[20px] p-5 min-h-[80px]">
                                    <img src="{{ asset('sewa/public/assets/svgs/logo-midtrans.svg') }}" alt="">
                                    <p class="text-base font-semibold">
                                        Midtrans
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div> --}}
                    <!-- CTA Button -->
                    <div class="col-span-2 mt-5">
                        @if($booking->payment && $booking->payment->status == 'Paid')
                        <div class="p-4 bg-green-100 text-green-800 text-sm rounded-lg border border-green-300">
                            <p class="font-semibold" style="color: green">
                                Telah dibayar pada tanggal
                                {{ $booking->payment->payment_date ? $booking->payment->payment_date->format('d M Y
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
                            <a href="{{ route('bookings.payment', $booking->slug) }}" class="btn-primary">
                                <p>
                                    Continue
                                </p>
                                <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}" alt="">
                            </a>
                        </div>
                        @endif
                    </div>

                </div>
            </form>
            <img src="{{ asset('sewa/public/assets/images/porsche_small.webp') }}"
                class="max-w-[50%] hidden lg:block -mr-[100px]" alt="">
        </div>
    </div>
</section>
@endsection
