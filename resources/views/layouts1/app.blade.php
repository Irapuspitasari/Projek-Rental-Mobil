<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sewa/public/css/main.css') }}">
</head>

<body>
    @include('layouts1.navbar')

    <!-- Hero -->
    @yield('content')

    <footer class="py-10 md:pt-[100px] md:pb-[70px] container">
        <p class="text-base text-center text-secondary">
            All Rights Reserved. Copyright BuildWith Angga 2023.
        </p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 300, easing: 'ease-out' });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('sewa/public/scripts/script.js') }}"></script>
</body>

</html>
