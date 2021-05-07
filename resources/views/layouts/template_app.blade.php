<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MGBK SMA Kota Malang') }} @yield('title')</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    {{-- Buefy CSS --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css"> --}}

    <!-- DataTable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bulma.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.0/css/bulma.min.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css"> --}}
    
    <!-- DatePicker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bulma-calendar.min.css') }}">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- =========================================================================================================================== -->

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTable -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bulma.min.js"></script>

    <!-- DatePicker -->
    {{-- <script src="{{ asset('js/bulma-calendar.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bulma-calendar@6.0.9/dist/js/bulma-calendar.min.js" integrity="sha256-j5R7XaUm/P3SCc5bo5XQ8maH3vkFFlXNSeg4ckGiO0k=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous"></script>

    <!-- Buefy components -->
    <script src="https://unpkg.com/vue"></script>
    <!-- Full bundle -->
    <script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>

    <!-- Individual components -->
    <script src="https://unpkg.com/buefy/dist/components/table"></script>
    <script src="https://unpkg.com/buefy/dist/components/input"></script>

    <style>
        .card, .white-blue{
            background-color: #f5f5f5 !important; 
        }

        .modal-card{
            overflow-y: auto ;
        }

        .modal .datetimepicker {
            display: none;
            max-height: 95vh;
            width: 22rem;
            max-width: 95vw;
            overflow-y: auto;

        }
        
        .datetimepicker.is-active {
            display: block;
        }
    </style>
    
</head>
<body class="has-navbar-fixed-top">
    
    <section class="section">
        @yield('content')
    </section>

    <p class="mt-4 has-text-centered">
        &copy; MGBK SMA Kota Malang
    </p>

    <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    <script src="{{ asset('js/bulma-steps.min.js') }}"></script>
    <script src="{{ asset('js/nav.js') }}"></script>
</body>
</html>
