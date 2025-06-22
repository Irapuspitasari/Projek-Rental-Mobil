@extends('layouts1.app')
@section('content')
{{-- <section class="container relative pb-[100px] pt-[30px]">
    <div class="flex flex-col items-center justify-center gap-[30px]">
        <!-- Preview Image -->
        <div class="relative">
            <div class="absolute z-0 hidden lg:block">
                <div class="font-extrabold text-[220px] text-darkGrey tracking-[-0.06em] leading-[101%]">
                    <div data-aos="fade-right" data-aos-delay="300">
                        NEW
                    </div>
                    <div data-aos="fade-left" data-aos-delay="600">
                        PORSCHE
                    </div>
                </div>
            </div>
            <img src="{{ asset('sewa/public/assets/images/porsche.webp') }}" class="w-full max-w-[963px] z-10 relative"
                alt="Porsche Car" data-aos="zoom-in" data-aos-delay="950">
        </div>

        <div class="flex flex-col lg:flex-row items-center justify-around lg:gap-[60px] gap-7">
            <!-- Car Details -->
            <div class="flex items-center gap-y-12">
                <div class="flex flex-col items-center gap-[2px] px-3 md:px-10" data-aos="fade-left"
                    data-aos-delay="1400">
                    <h6 class="font-bold text-dark text-xl md:text-[26px] text-center">
                        380
                    </h6>
                    <p class="text-sm font-normal text-center md:text-base text-secondary">
                        Horse Power
                    </p>
                </div>
                <span class="vr" data-aos="fade-left" data-aos-delay="1600"></span>
                <div class="flex flex-col items-center gap-[2px] px-3 md:px-10" data-aos="fade-left"
                    data-aos-delay="1900">
                    <h6 class="font-bold text-dark text-xl md:text-[26px] text-center">
                        12S
                    </h6>
                    <p class="text-sm font-normal text-center md:text-base text-secondary">
                        Speed AT
                    </p>
                </div>
                <span class="vr" data-aos="fade-left" data-aos-delay="2100"></span>
                <div class="flex flex-col items-center gap-[2px] px-3 md:px-10" data-aos="fade-left"
                    data-aos-delay="2400">
                    <h6 class="font-bold text-dark text-xl md:text-[26px] text-center">
                        AWD
                    </h6>
                    <p class="text-sm font-normal text-center md:text-base text-secondary">
                        Drive
                    </p>
                </div>
                <span class="vr" data-aos="fade-left" data-aos-delay="2600"></span>
                <div class="flex flex-col items-center gap-[2px] px-3 md:px-10" data-aos="fade-left"
                    data-aos-delay="2900">
                    <h6 class="font-bold text-dark text-xl md:text-[26px] text-center">
                        A.I
                    </h6>
                    <p class="text-sm font-normal text-center md:text-base text-secondary">
                        Tracking
                    </p>
                </div>
            </div>
            <!-- Button Primary -->
            <div class="p-1 rounded-full bg-primary group" data-aos="zoom-in" data-aos-delay="3400">
                <a href="checkout.html" class="btn-primary">
                    <p>
                        Rent Now
                    </p>
                    <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}" alt="" />
                </a>
            </div>
        </div>
    </div>
</section> --}}

<!-- Popular Cars -->
<section class="bg-darkGrey">
    <div class="container relative py-[100px]">
        <header class="mb-[30px]">
            <h2 class="font-bold text-dark text-[26px] mb-1">
                Daftar Mobil
            </h2>
            <p class="text-base text-secondary">Start your big day</p>
        </header>

        <!-- Cars -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-[29px]">
            @foreach($popularItems as $item)
            <!-- Card -->
            <div class="card-popular">
                <div>
                    <h5 class="text-lg text-dark font-bold mb-[2px]">
                        {{ $item->name }}
                    </h5>
                    <p class="text-sm font-normal text-secondary">{{ $item->type->name }}</p>
                    <a href="{{ route('items.show', $item->slug) }}" class="absolute inset-0"></a>
                </div>
                @if($item->photos)
                    <img src="{{ asset('storage/'.json_decode($item->photos)[0]) }}"
                        class="rounded-[18px] min-w-[216px] w-full h-[150px] object-cover"
                        alt="{{ $item->name }}" />
                @else
                    <div class="rounded-[18px] min-w-[216px] w-full h-[150px] bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                <div class="flex items-center justify-between gap-1">
                    <!-- Price -->
                    <p class="text-sm font-normal text-secondary">
                        <span class="text-base font-bold text-primary">${{ number_format($item->price) }}</span>/day
                    </p>
                    <!-- Rating -->
                    @php
                        $averageRating = $item->reviews->avg('star');
                        $reviewCount = $item->reviews->count();
                    @endphp
                    <p class="text-dark text-xs font-semibold flex items-center gap-[2px]">
                        @if($reviewCount > 0)
                            ({{ number_format($averageRating, 1) }}/5)
                            <img src="{{ asset('sewa/public/assets/svgs/ic-star.svg') }}" alt="Star Icon">
                        @else
                            (No reviews)
                        @endif
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
