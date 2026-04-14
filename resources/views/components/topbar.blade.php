@props(['sidebarToggle' => false])

<header class="sticky top-0 z-20 flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4 backdrop-blur">
    <div class="flex items-center gap-3">
        @if ($sidebarToggle)
            <button @click="sidebarOpen = !sidebarOpen" class="rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        @endif
        <div>
            <div class="text-sm text-slate-500">Selamat datang</div>
            <div class="text-lg font-semibold text-slate-900">{{ $slot }}</div>
        </div>
    </div>

    <details class="group relative">
        <summary class="flex cursor-pointer list-none items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700 transition hover:border-sky-200">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sky-700">{{ auth()->user()?->initials() }}</span>
            <span class="hidden sm:block">{{ auth()->user()?->name ?? "Unkown" }}</span>
            <span class="text-slate-400 transition group-open:rotate-180">⌄</span>
        </summary>
        <div class="absolute right-0 z-20 mt-3 w-48 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-sky-100/60">
            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-3 text-sm text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full rounded-xl px-4 py-3 text-left text-sm text-rose-600 transition hover:bg-rose-50 hover:text-rose-700">
                    Logout
                </button>
            </form>
        </div>
    </details>
</header>
