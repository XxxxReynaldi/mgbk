<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MGBK Malang') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="has-navbar-fixed-top">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">
                <span class="subtitle"><strong>MGBK Malang</strong></span>
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarTop">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarTop" class="navbar-menu">
            <div class="navbar-end mr-4">
                <a class="navbar-item" href="/home.html">
                    <span class="icon">
                        <i class="fas fa-home"></i>
                    </span>
                    <span>
                        Home
                    </span>
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <span class="icon">
                            <i class="fas fa-sticky-note"></i>
                        </span>
                        <span>
                            Laporan
                        </span>
                    </a>

                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href="/buat-laporan.html">
                            <span class="icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span>
                                Buat Laporan
                            </span>
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="/laporan.html">
                            <span class="icon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span>
                                Lihat Laporan
                            </span>
                        </a>
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <span class="icon">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        <span>
                            Profil
                        </span>
                    </a>

                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href="/profil.html">
                            <span class="icon">
                                <i class="fas fa-user"></i>
                            </span>
                            <span>
                                Lihat Profil
                            </span>
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item has-text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <span class="icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span>
                                Sign Out
                            </span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
    </nav>

    <section class="section">
        @yield('content')
    </section>

    <p class="mt-4 has-text-centered">
        &copy; MGBK Malang
    </p>

    <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    <script src="js/bulma-steps.min.js"></script>
    <script src="js/nav.js"></script>
</body>
</html>
