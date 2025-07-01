@extends('layouts1.app')
@section('content')

<!-- Popular Cars -->
<section class="bg-darkGrey">
    <div class="container relative py-[100px]">
        <header class="mb-[30px]">
            <h2 class="font-bold text-dark text-[26px] mb-1">
                Daftar Mobil
            </h2>
            <p class="text-base text-secondary">Start your big day</p>
        </header>

        <!-- Available Cars -->
        <div class="mb-10">
            <h3 class="font-bold text-dark text-[22px] mb-4">Available Cars</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-[29px]">
                @foreach($availableItems as $item)
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
        <br>
        <hr class="my-10 border-red-500">
        <hr class="my-10 border-red-500">
        <hr class="my-10 border-red-500">
        <hr class="my-10 border-red-500">
        <hr class="my-10 border-red-500">
        <hr class="my-10 border-red-500">
        <br>
        <!-- Unavailable Cars -->
        <div class="mt-20">
            <h3 class="font-bold text-[22px] mb-4" style="color: red">Unavailable Cars</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-[29px]">
                @foreach($unavailableItems as $item)
                <!-- Card -->
                <div class="card-popular">
                    <div>
                        <h5 class="text-lg text-dark font-bold mb-[2px]">
                            {{ $item->name }}
                        </h5>
                        <p class="text-sm font-normal text-secondary">{{ $item->type->name }}</p>
                        {{-- <a href="#" class="absolute inset-0"></a> --}}
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
    </div>
</section>

@endsection
