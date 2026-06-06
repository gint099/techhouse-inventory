<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} | TechHouse</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    </head>
    <body class="login-page bg-body-secondary">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <b>Tech</b>House
                </a>
            </div>

            <div class="card card-outline card-primary shadow">
                <div class="card-header text-center border-0 pt-4 pb-0">
                    <h1 class="h4 mb-1">{{ $title }}</h1>
                    @if ($subtitle)
                        <p class="text-muted small mb-0">{{ $subtitle }}</p>
                    @endif
                </div>

                <div class="card-body login-card-body">
                    {{ $slot }}
                </div>
            </div>

            <p class="text-center text-muted small mt-3 mb-0">
                &copy; {{ date('Y') }} TechHouse — Sistem Inventaris Barang
            </p>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/adminlte.js') }}"></script>
    </body>
</html>
