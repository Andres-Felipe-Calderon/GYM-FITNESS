<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gym') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- Añadir Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">
<!-- index.html -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Preload CSS -->
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js' defer></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-200 via-purple-300 to-pink-400 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">


    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    @vite(['resources/js/app.js'])
</body>
</html>