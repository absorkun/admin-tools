<x-dashboard-shell title="Tambah Laporan" active="helpdesk-log">
                    <x-page-hero
                        eyebrow="Helpdesk"
                        title="Tambah laporan baru"
                        description="Catat laporan dari WhatsApp, email, atau telepon. Isi lengkap supaya mudah dilacak."
                    />

                    <x-panel-card>
                        <form method="POST" action="{{ route('helpdesk-log.store') }}" class="space-y-6">
                            @csrf

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
                                    <label for="pelapor_nama" class="mb-2 block text-sm font-medium text-slate-700">Nama Pelapor</label>
                                    <input id="pelapor_nama" name="pelapor_nama" type="text" value="{{ old('pelapor_nama') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Nama / instansi pelapor">
                                </div>

                                <div>
                                    <label for="pelapor_phone" class="mb-2 block text-sm font-medium text-slate-700">Nomor Kontak</label>
                                    <input id="pelapor_phone" name="pelapor_phone" type="text" value="{{ old('pelapor_phone') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="08xxxxxxxxxx">
                                </div>

                                <div>
                                    <label for="pelapor_email" class="mb-2 block text-sm font-medium text-slate-700">Email (opsional)</label>
                                    <input id="pelapor_email" name="pelapor_email" type="email" value="{{ old('pelapor_email') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="email@instansi.go.id">
                                </div>

                                <div>
                                    <label for="domain" class="mb-2 block text-sm font-medium text-slate-700">Nama Domain (harus terdaftar)</label>
                                    <input id="domain" name="domain" type="text" value="{{ old('domain') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="contoh: komdigi.go.id">
                                </div>

                                <div>
                                    <label for="jenis_layanan" class="mb-2 block text-sm font-medium text-slate-700">Jenis Layanan</label>
                                    <select id="jenis_layanan" name="jenis_layanan" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        <option value="">-- Pilih jenis layanan --</option>
                                        @foreach (\App\Models\HelpdeskLog::JENIS_LAYANAN as $jl)
                                            <option value="{{ $jl }}" @selected(old('jenis_layanan') === $jl)>{{ $jl }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="kanal" class="mb-2 block text-sm font-medium text-slate-700">Kanal</label>
                                    <select id="kanal" name="kanal" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        <option value="">-- Pilih kanal --</option>
                                        @foreach (\App\Models\HelpdeskLog::KANAL as $k)
                                            <option value="{{ $k }}" @selected(old('kanal') === $k)>{{ $k }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Tulis deskripsi laporan di sini...">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                    Simpan laporan
                                </button>
                                <a href="{{ route('helpdesk-log.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </x-panel-card>
</x-dashboard-shell>
