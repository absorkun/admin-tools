<x-layouts.app title="Login">
    <div class="grid min-h-screen place-items-center px-6 py-12">
        <div class="grid w-full max-w-7xl gap-8 lg:grid-cols-[1.05fr_.95fr]">
            <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm shadow-sky-100/50">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-sky-600">Login</p>
                    <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900">
                        Masuk ke panel domain
                    </h1>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-600">
                        Login page simpel. Fokus ke akses internal, bukan visual berlebihan.
                    </p>
                </div>
                <div class="mt-10 rounded-3xl bg-slate-50 p-5 text-sm text-slate-600">
                    Gunakan kredensial tim yang valid.
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm shadow-sky-100/50">
                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf
                    @if ($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Username</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="w-full rounded-2xl border px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300 @error('name') border-rose-300 bg-rose-50 @else border-slate-200 bg-slate-50 @enderror"
                            placeholder="johndoe"
                        >
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="w-full rounded-2xl border px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300 @error('password') border-rose-300 bg-rose-50 @else border-slate-200 bg-slate-50 @enderror"
                            placeholder="••••••••"
                        >
                        {{-- @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror --}}
                    </div>
                    <div class="flex items-center justify-between text-sm text-slate-500">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                            Remember me
                        </label>
                        <a tabindex="99" href="{{ route('landing') }}" class="text-sky-600 hover:text-sky-700">Kembali</a>
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-sky-500 px-4 py-3 font-medium text-white transition hover:bg-sky-400">
                        Masuk
                    </button>
                </form>
            </section>
        </div>
    </div>
</x-layouts.app>
