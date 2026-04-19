<x-dashboard-shell title="Tambah Laporan" active="helpdesk-log">
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

                                <div x-data="{
                                    query: '{{ old('domain') }}',
                                    selected: '{{ old('domain') }}',
                                    results: [],
                                    loading: false,
                                    searched: false,
                                    async cari() {
                                        this.loading = true;
                                        this.searched = false;
                                        const res = await fetch('{{ route('domain.search') }}?q=' + encodeURIComponent(this.query));
                                        this.results = await res.json();
                                        this.loading = false;
                                        this.searched = true;
                                    },
                                    pilih(name, zone) {
                                        this.selected = name;
                                        this.query = name + zone;
                                        this.results = [];
                                        this.searched = false;
                                    }
                                }">
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Nama Domain (harus terdaftar)</label>
                                    <input type="hidden" name="domain" :value="selected">
                                    <div class="flex gap-2">
                                        <input type="text" x-model="query" @keydown.enter.prevent="cari()" placeholder="Cari nama domain..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                                        <button type="button" @click="cari()" :disabled="loading" class="shrink-0 rounded-2xl bg-sky-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-sky-400 disabled:opacity-50">
                                            <span x-show="!loading">Cari</span>
                                            <span x-show="loading" x-cloak>...</span>
                                        </button>
                                    </div>
                                    <div x-show="searched && results.length === 0" x-cloak class="mt-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                                        Domain tidak ditemukan.
                                    </div>
                                    <div x-show="results.length > 0" x-cloak class="mt-1 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
                                        <template x-for="d in results" :key="d.name">
                                            <button type="button" @click="pilih(d.name, d.zone)" class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm transition hover:bg-sky-50">
                                                <span class="flex-1 font-medium text-slate-900" x-text="d.name + d.zone"></span>
                                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-500" x-text="d.status ?? '-'"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div x-data="{ layanan: '{{ old('jenis_layanan') }}' }">
                                    <label for="jenis_layanan" class="mb-2 block text-sm font-medium text-slate-700">Jenis Layanan</label>
                                    <select id="jenis_layanan" name="jenis_layanan" x-model="layanan" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        <option value="">-- Pilih jenis layanan --</option>
                                        @foreach (\App\Models\HelpdeskLog::JENIS_LAYANAN as $jl)
                                            <option value="{{ $jl }}" @selected(old('jenis_layanan') === $jl)>{{ $jl }}</option>
                                        @endforeach
                                    </select>
                                    <input x-show="layanan === 'Lainnya'" x-cloak type="text" name="jenis_layanan_lainnya" value="{{ old('jenis_layanan_lainnya') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Ketik jenis layanan...">
                                </div>

                                <div x-data="{ kanal: '{{ old('kanal') }}' }">
                                    <label for="kanal" class="mb-2 block text-sm font-medium text-slate-700">Kanal</label>
                                    <select id="kanal" name="kanal" x-model="kanal" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        <option value="">-- Pilih kanal --</option>
                                        @foreach (\App\Models\HelpdeskLog::KANAL as $k)
                                            <option value="{{ $k }}" @selected(old('kanal') === $k)>{{ $k }}</option>
                                        @endforeach
                                    </select>
                                    <input x-show="kanal === 'Lainnya'" x-cloak type="text" name="kanal_lainnya" value="{{ old('kanal_lainnya') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Ketik kanal...">
                                </div>

                                <div>
                                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                                    <select id="status" name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        @foreach (\App\Models\HelpdeskLog::STATUSES as $s)
                                            <option value="{{ $s }}" @selected(old('status', \App\Models\HelpdeskLog::STATUS_DIPROSES) === $s)>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-700">Pertanyaan</label>
                                <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Tulis deskripsi laporan di sini...">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div>
                                <label for="catatan_tambahan" class="mb-2 block text-sm font-medium text-slate-700">Jawaban (opsional)</label>
                                <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Catatan internal atau tindak lanjut...">{{ old('catatan_tambahan') }}</textarea>
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
