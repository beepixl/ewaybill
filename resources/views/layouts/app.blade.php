<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @isset($meta)
        {{ $meta }}
    @endisset

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('globe.png') }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/nunito-sans.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/notyf/notyf.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css"
        media="all">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css"
        media="all">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">

    <livewire:styles />

    <style>
        .select2-container--open {
            z-index: 9999999 !important;
            width: 100% !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            width: 265px !important;
            line-height: 28px;
        }
    </style>

    <!-- Scripts -->
    <script defer src="{{ asset('vendor/alpine.js') }}"></script>

</head>

<body class="antialiased test2">
    <div id="app">
        <div class="main-wrapper">
            @include('components.navbar')
            @include('components.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        @isset($header_content)
                            {{ $header_content }}
                        @else
                            {{ __('Welcome Admin') }}
                        @endisset
                    </div>

                    <div class="section-body">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </div>

    @stack('modals')

    <!-- General JS Scripts -->
    <script src="{{ asset('stisla/js/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/popper.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/tooltip.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/bootstrap.min.js') }}"></script>
    <script src="https://demo.getstisla.com/assets/modules/tooltip.js"></script>

    <script src="{{ asset('stisla/js/modules/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/moment.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/marked.min.js') }}"></script>
    <script src="{{ asset('vendor/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('stisla/js/modules/chart.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

    <script src="{{ asset('stisla/js/stisla.js') }}"></script>
    <script src="{{ asset('stisla/js/scripts.js') }}"></script>
    <script src="https://demo.getstisla.com/assets/js/page/bootstrap-modal.js"></script>

    <livewire:scripts />

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script type="text/javascript">
        const notyf = new Notyf({
            position: {
                x: 'center',
                'y': 'button'
            }
        });
    </script>

    @stack('additional-sctipt')
</body>

</html>
