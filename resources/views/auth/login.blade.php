<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <link rel="stylesheet" href="{{ asset('sewa/public/css/main.css') }}">
</head>

<body>
    <nav class="container relative my-4 lg:my-10">
        <div class="flex flex-col justify-between w-full lg:flex-row lg:items-center">
            <!-- Logo & Toggler Button here -->
            <div class="flex items-center justify-between">
                <!-- LOGO -->
                <a href="/login">
                    <img src="{{ asset('sewa/public/assets/svgs/logo.svg') }}" alt="stream" />
                </a>
                <!-- RESPONSIVE NAVBAR BUTTON TOGGLER -->
                <div class="block lg:hidden">
                    <button class="p-1 outline-none mobileMenuButton" id="navbarToggler" data-target="#navigation">
                        <svg class="text-dark w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Nav Menu -->
            <div class="hidden w-full lg:block" id="navigation">
                <div
                    class="flex flex-col items-baseline gap-4 mt-6 lg:justify-between lg:flex-row lg:items-center lg:mt-0">
                    <div class="flex flex-col w-full ml-auto lg:w-auto gap-4 lg:gap-[50px] lg:items-center lg:flex-row">
                        <a href="./index.html" class="nav-link-item">Landing</a>
                        <a href="#!" class="nav-link-item">Catalog</a>
                        <a href="#!" class="nav-link-item">Benefits</a>
                        <a href="#!" class="nav-link-item">Stories</a>
                        <a href="#!" class="nav-link-item">Maps</a>
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
                        Sign In & Drive
                    </h2>
                    <p class="text-base text-secondary">We will help you get ready today</p>
                </header>
                <!-- Form Card -->
                <!-- Ganti form dengan method POST dan CSRF protection -->
                <form action="{{ route('login') }}" method="POST"
                    class="bg-white p-[30px] pb-10 rounded-3xl max-w-[490px] w-full">
                    @csrf
                    <div class="grid grid-cols-2 items-center gap-y-6 gap-x-4 lg:gap-x-[30px]">
                        <!-- Email -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="email" class="text-base font-semibold text-dark">
                                Email Address
                            </label>
                            <input type="email" name="email" id="email"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Insert Email Address" value="{{ old('email') }}" required autofocus>
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
                            <a href="{{ route('password.request') }}"
                                class="mt-1 text-base text-right underline text-secondary underline-offset-2">
                                Forgot My Password
                            </a>
                        </div>
                        <!-- Remember Me -->
                        <div class="col-span-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-secondary">Remember me</span>
                            </label>
                        </div>
                        <!-- Sign In Button -->
                        <div class="col-span-2 mt-[26px]">
                            <!-- Ganti anchor tag dengan button submit -->
                            <button type="submit" class="p-1 rounded-full bg-primary group w-full">
                                <div class="btn-primary">
                                    <p>Sign In</p>
                                    <img src="{{ asset('sewa/public/assets/svgs/ic-arrow-right.svg') }}"
                                        alt="Right Arrow">
                                </div>
                            </button>
                        </div>
                        <!-- Create New Account Button -->
                        <div class="col-span-2">
                            <a href="{{ route('register') }}" class="btn-secondary">
                                <p>Create New Account</p>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('sewa/public/scripts/script.js') }}"></script>
</body>

</html>
