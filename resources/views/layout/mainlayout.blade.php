<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WKM Management - @yield('name')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoWKM.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased font-sans text-gray-900 bg-gray-100 flex flex-col min-h-screen">

    @include('layout.internal_nav')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layout.footer')

</body>
</html>