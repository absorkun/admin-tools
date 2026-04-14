@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' - ' : '' }}{{ config('app.name', 'Domain Admin') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-stone-100 text-slate-900 antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(96,165,250,.20),_transparent_28%),linear-gradient(180deg,#fafafa_0%,#eff6ff_100%)]">
        {{ $slot }}
    </div>
</body>
</html>
