<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- icons --}}
        <link rel="apple-touch-icon" sizes="180x180" href={{asset('icons/apple-touch-icon.png')}}>
        <link rel="icon" type="image/png" sizes="32x32" href={{asset('icons/favicon-32x32.png')}}>
        <link rel="icon" type="image/png" sizes="16x16" href={{asset('icons/favicon-16x16.png')}}>
        <link rel="manifest" href={{asset('icons/site.webmanifest')}}>
        <link rel="mask-icon" href={{asset('icons/safari-pinned-tab.svg')}} color="#5bbad5">
        <meta name="apple-mobile-web-app-title" content="SleepyBaby">
        <meta name="application-name" content="SleepyBaby">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            @include('layouts.admin-navigation')


            <!-- Page Content -->
            <main class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
