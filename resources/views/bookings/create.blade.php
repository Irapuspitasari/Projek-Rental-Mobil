@extends('layouts1.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- Laravel asset helper for CSS -->
    <link rel="stylesheet" href="{{ asset('sewa/public/css/main.css') }}">
    <script defer src="https://unpkg.com/alpinejs@3.7.0/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Main Content -->
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
                <form action="{{ route('bookings.store') }}" method="POST"
                    class="bg-white p-[30px] pb-10 rounded-3xl max-w-[490px] w-full" x-data="app" x-cloak>
                    @csrf

                    <div class="grid grid-cols-2 items-center gap-y-6 gap-x-4 lg:gap-x-[30px]">
                        <!-- Full Name -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="name" class="text-base font-semibold text-dark">
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Nama Lengkap">
                        </div>

                        <!-- Address -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="address" class="text-base font-semibold text-dark">
                                Alamat
                            </label>
                            <input type="text" name="address" id="address" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Alamat">
                            {{-- <textarea name="address" id="address" rows="3" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-2xl"
                                placeholder="Alamat Lengkap"></textarea> --}}
                        </div>

                        <!-- City -->
                        <div class="flex flex-col col-span-1 gap-3">
                            <label for="city" class="text-base font-semibold text-dark">
                                Kota
                            </label>
                            <input type="text" name="city" id="city" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Nama Kota">
                        </div>

                        <!-- Zip Code -->
                        <div class="flex flex-col col-span-1 gap-3">
                            <label for="zip" class="text-base font-semibold text-dark">
                                Kode Pos
                            </label>
                            <input type="text" name="zip" id="zip"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Kode Pos">
                        </div>

                        <!-- Item Selection - Hanya ditampilkan jika tidak ada item tertentu -->
                        @if(!isset($item))
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="item_id" class="text-base font-semibold text-dark">
                                Pilih Item
                            </label>
                            <select name="item_id" id="item_id" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] appearance-none">
                                <option value="">-- Pilih Item --</option>
                                @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - Rp {{ number_format($item->price, 0,
                                    ',', '.') }}/hari</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <!-- Jika ada item tertentu, buat input hidden -->
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        @endif


                        <!-- Date Range Picker -->
                        <div class="col-span-2 grid grid-cols-2 gap-y-6 gap-x-4 lg:gap-x-[30px]">
                            <!-- Start Date -->
                            <div class="flex flex-col col-span-1 gap-3">
                                <label for="start_date" class="text-base font-semibold text-dark">
                                    Mulai
                                </label>
                                <input type="date" name="start_date" id="start_date" required
                                    class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] appearance-none">
                            </div>
                            <!-- End Date -->
                            <div class="flex flex-col col-span-1 gap-3">
                                <label for="end_date" class="text-base font-semibold text-dark">
                                    Selesai
                                </label>
                                <input type="date" name="end_date" id="end_date" required
                                    class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] appearance-none">
                            </div>
                        </div>

                        <!-- Region -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="region" class="text-base font-semibold text-dark">
                                Daerah Sewa
                            </label>
                            <select name="region" id="region" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] appearance-none">
                                <option value="">-- Pilih Daerah --</option>
                                <option value="Jateng">Jawa Tengah</option>
                                <option value="DIY">Daerah Istimewa Yogyakarta</option>
                                <option value="Luar Provinsi">Luar Provinsi</option>
                            </select>
                        </div>

                        <!-- Driver Option -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label class="text-base font-semibold text-dark">
                                Opsi Driver
                            </label>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="driver_option" id="with_driver" value="With Driver"
                                        required class="w-5 h-5 text-primary focus:ring-primary border-grey">
                                    <label for="with_driver" class="text-base font-medium text-dark">Dengan
                                        Driver</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="driver_option" id="without_driver" value="Without Driver"
                                        class="w-5 h-5 text-primary focus:ring-primary border-grey">
                                    <label for="without_driver" class="text-base font-medium text-dark">Tanpa
                                        Driver</label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="notes" class="text-base font-semibold text-dark">
                                Catatan
                            </label>
                            <input type="text" name="notes" id="notes" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Catatan tambahan">
                            {{-- <textarea name="notes" id="notes" rows="2"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-2xl"
                                placeholder="Catatan tambahan"></textarea> --}}
                        </div>

                        <!-- Submit Button -->
                        <div class="col-span-6 mt-[26px]">
                                <button type="submit" class="btn-primary">
                                    Buat Booking
                                    {{-- <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}" alt="">
                                    --}}
                                </button>
                        </div>
                    </div>
                </form>

                <img src="{{ asset('sewa/public/assets/images/porsche_small.webp') }}"
                    class="max-w-[50%] hidden lg:block -mr-[100px]" alt="">
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- Laravel asset helper for JS files -->
    <script type="text/javascript" src="{{ asset('sewa/public/scripts/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sewa/public/scripts/dateRangePicker.js') }}"></script>
</body>

</html>
@endsection
