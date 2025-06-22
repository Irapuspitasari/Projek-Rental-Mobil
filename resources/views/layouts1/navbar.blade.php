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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Nav Menu -->
        <div class="hidden w-full lg:block" id="navigation">
            <div class="flex flex-col items-baseline gap-4 mt-6 lg:justify-between lg:flex-row lg:items-center lg:mt-0">
                <div class="flex flex-col w-full ml-auto lg:w-auto gap-4 lg:gap-[50px] lg:items-center lg:flex-row">
                    <a href="/" class="nav-link-item active">Landing</a>
                    <a href="/car" class="nav-link-item">Catalog</a>
                    <a href="#!" class="nav-link-item">Benefits</a>
                    <a href="#!" class="nav-link-item">Stories</a>
                    <a href="#!" class="nav-link-item">Maps</a>
                </div>
                <div class="flex flex-col w-full ml-auto lg:w-auto lg:gap-12 lg:items-center lg:flex-row">
                    @auth
                    <!-- Tampilkan ini jika user sudah login -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-primary">
                            Log Out
                        </button>
                    </form>
                    @else
                    <!-- Tampilkan ini jika user belum login -->
                    <a href="{{ route('login') }}" class="btn-secondary">
                        Log In
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
