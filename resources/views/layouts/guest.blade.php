<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilo para el fondo */
        .background {
            background-image: url('{{ asset('images/fondoweb.jpg') }}'), url('{{ asset('images/descarga.jfif') }}');
            background-size: cover, cover; /* Asegúrate de que ambas imágenes cubran el área */
            background-position: center; /* Centra las imágenes */
            height: 100vh; /* Asegúrate de que ocupe toda la altura de la vista */
        }

        /* Ajustes para móviles */
        @media (max-width: 640px) { /* Cambia el valor según tus necesidades */
            .background {
                background-image: url('{{ asset('images/descarga.jfif') }}');
            }
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="background flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
        <a href="/">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-32 w-auto" /> <!-- Ajusta el tamaño aquí -->
</a>

        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-black bg-opacity-60 dark:bg-gray-800 dark:bg-opacity-80 shadow-md overflow-hidden sm:rounded-lg">
    {{ $slot }}
</div>


    </div>
</body>
</html>
