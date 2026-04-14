<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Domain Admin') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-100 text-slate-900 antialiased">
    <main class="mx-auto flex min-h-screen max-w-7xl items-center px-6 py-12 lg:px-10">
        <div class="grid w-full gap-8 lg:grid-cols-[1.2fr_.8fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm shadow-sky-100/50">
                <p class="text-sm uppercase tracking-[0.24em] text-sky-600">Domain panel</p>
                <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 md:text-6xl">
                    Kelola domain, DNS, dan log expiry dalam satu tempat.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600">
                    Landing page internal. Fokus ke data penting, tampilan rapi, dan alur kerja cepat.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                        Masuk
                    </a>
                    <a href="{{ route('dashboard') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                        Dashboard
                    </a>
                </div>
            </section>

            <aside class="space-y-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Ringkas</span>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">Online</span>
                </div>

                <div class="grid gap-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-sm text-slate-500">DNS Server</div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">Monitoring aktif</div>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-sm text-slate-500">Email log</div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">Tracking expiry</div>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
