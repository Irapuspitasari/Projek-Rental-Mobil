<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link rel="stylesheet" href="{{ asset('sewa/public/css/main.css') }}">
</head>

<body>
    <nav class="container relative my-4 lg:my-10">
        <div class="flex flex-col justify-between w-full lg:flex-row lg:items-center">
            <!-- Logo & Toggler Button here -->
            <div class="flex items-center justify-between">
                <!-- LOGO -->
                <a href="/">
                    <img src="{{ asset('sewa/public/assets/svgs/logo.svg') }}" alt="stream" />
                </a>
                <!-- RESPONSIVE NAVBAR BUTTON TOGGLER -->
                <div class="block lg:hidden">
                    <button class="p-1 outline-none mobileMenuButton" id="navbarToggler" data-target="#navigation">
                        <svg class="text-dark w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8h16M4 16h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Nav Menu -->
            <div class="hidden w-full lg:block" id="navigation">
                <div
                    class="flex flex-col items-baseline gap-4 mt-6 lg:justify-between lg:flex-row lg:items-center lg:mt-0">
                    <div class="flex flex-col w-full ml-auto lg:w-auto gap-4 lg:gap-[50px] lg:items-center lg:flex-row">
                        <a href="/" class="nav-link-item">Landing</a>
                        <a href="#!" class="nav-link-item">Catalog</a>
                        <a href="#!" class="nav-link-item">Benefits</a>
                        <a href="#!" class="nav-link-item">Stories</a>
                        <a href="#!" class="nav-link-item">Maps</a>
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link-item">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-link-item">Log In</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <section class="bg-darkGrey relative py-[70px]">
        <div class="container">
            <div class="flex flex-col items-center">
                <header class="mb-[30px] text-center">
                    <h2 class="font-bold text-dark text-[26px] mb-1">
                        Sign Up & Drive
                    </h2>
                    <p class="text-base text-secondary">We will help you get ready today</p>
                </header>
                <!-- Form Card -->
                <form method="POST" action="{{ route('register') }}" class="bg-white p-[30px] pb-10 rounded-3xl max-w-[490px] w-full" id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <!-- User Photo -->
                    <div class="mb-[50px] flex justify-center">
                        <div class="relative">
                            <img src="{{ asset('sewa/public/assets/svgs/ic-default-photo.svg') }}" class="w-[120px] h-[120px] rounded-full"
                                alt="Profile Photo" id="imageSrc">
                            <a href="javascript:void(0);" id="btnUploadPhoto" class="">
                                <img src="{{ asset('sewa/public/assets/svgs/ic-btn_upload.svg') }}"
                                    class="w-[36px] h-[36px] rounded-full absolute right-[-7px] bottom-[9px]"
                                    alt="Upload Photo">
                            </a>
                            <a href="javascript:void(0);" id="btnDeletePhoto" class="hidden">
                                <img src="{{ asset('sewa/public/assets/svgs/ic-btn_delete.svg') }}"
                                    class="w-[36px] h-[36px] rounded-full absolute right-[-7px] bottom-[9px]"
                                    alt="Delete Photo">
                            </a>
                        </div>
                        <input type="file" name="photo" id="photo" class="hidden"
                            accept="image/x-png,image/jpg,image/jpeg">
                        @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 items-center gap-y-6 gap-x-4 lg:gap-x-[30px]">
                        <!-- Full Name -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="name" class="text-base font-semibold text-dark">
                                Full Name
                            </label>
                            <input type="text" name="name" id="name"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Insert Full Name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Phone Number -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="phone" class="text-base font-semibold text-dark">
                                Phone Number
                            </label>
                            <input type="text" name="phone" id="phone"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Insert Phone Number" value="{{ old('phone') }}" required>
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="email" class="text-base font-semibold text-dark">
                                Email Address
                            </label>
                            <input type="email" name="email" id="email"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Insert Email Address" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Password -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="password" class="text-base font-semibold text-dark">
                                Password
                            </label>
                            <input type="password" name="password" id="password"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Insert password" required>
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Password Confirmation -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="password_confirmation" class="text-base font-semibold text-dark">
                                Confirm Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Confirm password" required>
                        </div>
                        <!-- Button -->
                        <div class="col-span-2 mt-[26px]">
                            <!-- Button Primary -->
                            <button type="submit" class="p-1 rounded-full bg-primary group w-full">
                                <div class="btn-primary">
                                    <p>Create My Account</p>
                                    <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}" alt="Arrow Right">
                                </div>
                            </button>
                        </div>
                        <!-- Sign In Link -->
                        <div class="col-span-2">
                            <a href="{{ route('login') }}" class="btn-secondary">
                                <p>Sign In</p>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="{{ asset('sewa/public/scripts/script.js') }}"></script>
    <script>
        // Image upload preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const btnUpload = document.getElementById('btnUploadPhoto');
            const btnDelete = document.getElementById('btnDeletePhoto');
            const inputPhoto = document.getElementById('photo');
            const imageSrc = document.getElementById('imageSrc');

            if (btnUpload && inputPhoto) {
                btnUpload.addEventListener('click', function() {
                    inputPhoto.click();
                });

                inputPhoto.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            imageSrc.src = event.target.result;
                            btnUpload.classList.add('hidden');
                            btnDelete.classList.remove('hidden');
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });

                btnDelete.addEventListener('click', function() {
                    imageSrc.src = "{{ asset('sewa/public/assets/svgs/ic-default-photo.svg') }}";
                    inputPhoto.value = '';
                    btnUpload.classList.remove('hidden');
                    btnDelete.classList.add('hidden');
                });
            }
        });
    </script>
</body>

</html>
