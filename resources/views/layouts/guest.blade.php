<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GameBid</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

<div class="min-h-screen relative overflow-hidden bg-slate-950">

    {{-- Grid Background --}}
    <div class="absolute inset-0 opacity-10"
         style="background-image:
         linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px),
         linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px);
         background-size: 40px 40px;">
    </div>

    {{-- Glow Effects --}}
    <div class="absolute top-20 left-20 w-96 h-96 bg-purple-600 rounded-full blur-[160px] opacity-20"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-600 rounded-full blur-[160px] opacity-20"></div>

    {{-- Logo/Header --}}
    <div class="absolute top-8 left-1/2 -translate-x-1/2 z-20">
        <h1 class="text-3xl font-bold text-white tracking-wide">
            🎮 <span class="text-purple-400">GameBid</span>
        </h1>
    </div>

    {{-- Content --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4">
        {{ $slot }}
    </div>

</div>

</body>
</html>