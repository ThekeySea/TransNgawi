<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TransNgawi') | Perjalanan Nyaman, Harga Pas</title>
    <meta name="description" content="@yield('meta_description', 'Pesan tiket bus TransNgawi dengan mudah. Perjalanan antarkota nyaman dan terjangkau.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col">
    <x-layout.navbar />

    <main class="flex-1 pt-16 lg:pt-20">
        @yield('content')
    </main>

    <x-layout.footer />

    @stack('scripts')
</body>
</html>
