@extends('layouts1.app')

@section('content')
<section class="bg-darkGrey relative py-[70px]">
    <div class="container">
        <!-- Breadcrumb -->
        <ul class="flex items-center gap-5 mb-[50px]">
            <li
                class="text-secondary font-normal text-base capitalize after:content-['/'] last:after:content-none inline-flex gap-5">
                <a href="/">Home</a>
            </li>
            <li
                class="text-dark font-semibold text-base capitalize after:content-['/'] last:after:content-none inline-flex gap-5">
                Details
            </li>
        </ul>

        <!-- Product Details Section (8:4 layout) -->
        <div class="grid grid-cols-12 gap-[30px]">
            <!-- Left Column (8/12) - Product Images -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white p-4 rounded-[30px] flex flex-col gap-4" id="gallery">
                    <img :src="thumbnails[activeThumbnail].url" :key="thumbnails[activeThumbnail].id"
                        class="md:h-[490px] rounded-[18px] h-auto w-full" alt="">
                    <div class="grid items-center grid-cols-4 gap-3 md:gap-5">
                        <div v-for="(thumbnail, index) in thumbnails" :key="thumbnail.id">
                            <a href="#!" @click="changeActive(index)">
                                <img :src="thumbnail.url" alt="" class="thumbnail"
                                    :class="{selected: index == activeThumbnail}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (4/12) - Product Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-white p-5 pb-[30px] rounded-3xl h-full">
                    <div class="flex flex-col h-full divide-y divide-grey">
                        <!-- Name, Category, Rating -->
                        <div class="max-w-[230px] pb-5">
                            <h1 class="font-bold text-[28px] leading-[42px] text-dark mb-[6px]">
                                {{ $item->brand->name }} <br> {{ $item->name }}
                            </h1>
                            <p class="text-secondary font-normal text-base mb-[10px]">{{ $item->type->name }}</p>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++) @if($i <=floor($averageRating)) <img
                                        src="{{ asset('sewa/public/assets/svgs/ic-star.svg') }}"
                                        class="h-[22px] w-[22px]" alt="star">
                                        @elseif($i - 0.5 <= $averageRating && $averageRating < $i) <img
                                            src="{{ asset('sewa/public/assets/ss.png') }}" class="h-[22px] w-[22px]"
                                            alt="half star">
                                            @else
                                            <img src="{{ asset('sewa/public/assets/ss.png') }}"
                                                class="h-[22px] w-[22px]" alt="empty star">
                                            @endif
                                            @endfor
                                </span>
                                <p class="text-base font-semibold text-dark mt-[2px]">
                                    {{ number_format($averageRating, 1) }}/5 ({{ $totalReviews }})
                                </p>
                            </div>
                        </div>

                        <!-- Features -->
                        <ul class="flex flex-col gap-4 flex-start pt-5 pb-[25px]">
                            @foreach(explode("\n", $item->features) as $feature)
                            @if(trim($feature))
                            <li class="flex items-center gap-3 text-base font-semibold text-dark">
                                <img src="{{ asset('sewa/public/assets/svgs/ic-checkDark.svg') }}" alt=""
                                    class="flex-shrink-0">
                                {{ trim($feature) }}
                            </li>
                            @endif
                            @endforeach
                        </ul>

                        <!-- Price, CTA Button -->
                        <div class="flex items-center justify-between gap-4 pt-5 mt-auto">
                            <div>
                                <p class="font-bold text-dark text-[22px]">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                                <p class="text-base font-normal text-secondary">
                                    /day
                                </p>
                            </div>
                            <div class="w-full max-w-[70%]">
                                <div class="p-1 rounded-full bg-primary group">
                                    <a href="{{ route('bookings.create', ['item_slug' => $item->slug]) }}"
                                        class="btn-primary">
                                        <p>Rent Now</p>
                                        <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}"
                                            alt="Rent Now">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section (8:4 layout) -->
        <div class="grid grid-cols-12 gap-[30px] mt-6">
            <!-- Left Column (8/12) - Reviews List -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white p-5 rounded-3xl">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-dark">Ulasan Produk</h2>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++) @if($i <=floor($averageRating)) <img
                                    src="{{ asset('sewa/public/assets/svgs/ic-star.svg') }}" class="h-6 w-6" alt="star">
                                    @elseif($i - 0.5 <= $averageRating && $averageRating < $i) <img
                                        src="{{ asset('sewa/public/assets/ss.png') }}" class="h-6 w-6" alt="half star">
                                        @else
                                        <img src="{{ asset('sewa/public/assets/ss.png') }}" class="h-6 w-6"
                                            alt="empty star">
                                        @endif
                                        @endfor
                            </div>
                            <span class="text-base font-semibold text-dark">
                                {{ number_format($averageRating, 1) }}/5 ({{ $totalReviews }} ulasan)
                            </span>
                        </div>
                    </div>
                    <hr class="my-4">

                    @forelse($item->reviews()->latest()->get() as $review)
                    <div class="py-4 border-b border-grey last:border-0">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-bold text-dark">{{ $review->user->name }}</h4>
                                <div class="flex items-center gap-1 mt-1">
                                    @for($i = 1; $i <= 5; $i++) @if($i <=floor($review->star))
                                        <img src="{{ asset('sewa/public/assets/svgs/ic-star.svg') }}" class="h-4 w-4"
                                            alt="star">
                                        @elseif($i - 0.5 <= $review->star && $review->star < $i) <img
                                                src="{{ asset('sewa/public/assets/ss.png') }}" class="h-4 w-4"
                                                alt="half star">
                                                @else
                                                <img src="{{ asset('sewa/public/assets/ss.png') }}" class="h-4 w-4"
                                                    alt="empty star">
                                                @endif
                                                @endfor
                                                <span class="text-secondary text-sm ml-2">
                                                    {{ $review->created_at->format('d M Y') }}
                                                </span>
                                </div>
                            </div>
                            @can('update', $review)
                            <div class="flex gap-2">
                                <button class="edit-review-btn" data-id="{{ $review->id }}"
                                    data-star="{{ $review->star }}" data-comment="{{ $review->comment }}">
                                    <i class="fa fa-edit h-5 w-5"></i> Edit
                                </button>
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus review ini?')">
                                        <img src="{{ asset('sewa/public/assets/svgs/ic-btn_delete.svg') }}"
                                            class="h-5 w-5" alt="Delete">
                                    </button>
                                </form>
                            </div>
                            @endcan
                        </div>
                        <p class="text-dark">{{ $review->comment }}</p>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <img src="{{ asset('sewa/public/assets/svgs/file-list-3-line.svg') }}"
                            class="h-16 w-16 mx-auto mb-4" alt="No reviews">
                        <p class="text-secondary">Belum ada ulasan untuk produk ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column (4/12) - Review Form -->
            <div class="col-span-12 lg:col-span-4">
                @auth
                <div class="bg-white p-5 rounded-3xl sticky top-6">
                    @if(!$item->hasUserReview(auth()->id()))
                    <h3 class="text-xl font-bold text-dark mb-4">Tulis Ulasan Anda</h3>
                    <form action="{{ route('items.reviews.store', $item->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-dark font-medium mb-2">Rating</label>
                            <div class="star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="fa-star{{ $i }}" name="star" value="{{ $i }}">
                                <label for="fa-star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>

                            @error('star')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-dark font-medium mb-2">Komentar</label>
                            <textarea name="comment" rows="3" class="w-full p-3 border border-grey rounded-lg"
                                required>{{ old('comment') }}</textarea>
                            @error('comment')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit"
                            class="bg-primary text-white py-3 px-6 rounded-full font-medium hover:bg-primary-dark transition">
                            Kirim Ulasan
                        </button>
                    </form>
                    @else
                    <div class="text-center py-6">
                        <img src="{{ asset('sewa/public/assets/svgs/ic-checkDark.svg') }}"
                            class="h-12 w-12 mx-auto mb-4" alt="Reviewed">
                        <p class="text-dark mb-4">Anda sudah memberikan ulasan untuk produk ini</p>
                        <a href="#user-review" class="text-primary font-medium">Lihat ulasan saya</a>
                    </div>
                    @endif
                </div>
                @else
                <div class="bg-white p-5 rounded-3xl text-center sticky top-6">
                    <img src="{{ asset('sewa/public/assets/svgs/login.svg') }}" class="h-12 w-12 mx-auto mb-4"
                        alt="Login">
                    <p class="text-dark mb-4">Login untuk memberikan ulasan</p>
                    <a href="{{ route('login') }}"
                        class="bg-primary text-white py-3 px-6 rounded-full font-medium inline-block hover:bg-primary-dark transition">
                        Login Sekarang
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>


<script src="https://unpkg.com/vue@next/dist/vue.global.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                activeThumbnail: 0,
                thumbnails: [
                    @if($item->photos && count(json_decode($item->photos)) > 0)
                        @foreach(json_decode($item->photos) as $index => $photo)
                        {
                            id: {{ $index + 1 }},
                            url: "{{ asset('storage/'.$photo) }}"
                        }@if(!$loop->last),@endif
                        @endforeach
                    @else
                        {
                            id: 1,
                            url: "{{ asset('sewa/public/assets/images/default-car.webp') }}"
                        }
                    @endif
                ],
            }
        },
        methods: {
            changeActive(id) {
                this.activeThumbnail = id;
            }
        },
        computed: {
            mainImage() {
                return this.thumbnails[this.activeThumbnail]?.url || '';
            }
        }
    }).mount('#gallery');
</script>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{ asset('sewa/public/scripts/script.js') }}"></script>
<script src="https://cdn.tailwindcss.com"></script>
<!-- Pastikan Font Awesome sudah ada -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    .star-rating {
        direction: rtl;
        font-size: 1rem;
        display: inline-flex;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        color: #ccc;
        cursor: pointer;
    }

    .star-rating input[type="radio"]:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #ffc107;
    }
</style>

@endsection
