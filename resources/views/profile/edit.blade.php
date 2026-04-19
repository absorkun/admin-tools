<x-dashboard-shell title="Profile" active="profile">
                    @if (session('status'))
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <x-panel-card>
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                    <ul class="list-inside list-disc space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Username</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Username">
                                </div>

                                <div>
                                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="email@example.com">
                                </div>

                                <div>
                                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password baru</label>
                                    <input id="password" name="password" type="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Kosongkan jika tidak diubah">
                                </div>

                                <div>
                                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Ulangi password baru">
                                </div>
                            </div>

                            <div>
                                <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Foto profil</label>
                                <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-sky-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-sky-700 hover:file:bg-sky-100 focus:border-sky-300">
                                <p class="mt-2 text-xs text-slate-500">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                    Simpan perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </x-panel-card>
</x-dashboard-shell>
