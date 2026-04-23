<x-dashboard-shell title="Helpdesk Report" active="helpdesk-log">
                    @if (session('status'))
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <a href="{{ route('helpdesk-log.create') }}" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                            + Tambah laporan
                        </a>
                    </div>

                    <x-filter-card :action="route('helpdesk-log.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div>
                            <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Domain</label>
                            <input id="search" name="search" value="{{ $search }}" type="text" placeholder="contoh: komdigi.go.id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                        </div>

                        <div>
                            <label for="date_from" class="mb-2 block text-sm font-medium text-slate-700">Dari Tanggal</label>
                            <input id="date_from" name="date_from" value="{{ $dateFrom }}" type="date" onchange="this.form.submit()" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                        </div>

                        <div>
                            <label for="date_to" class="mb-2 block text-sm font-medium text-slate-700">Sampai Tanggal</label>
                            <input id="date_to" name="date_to" value="{{ $dateTo }}" type="date" onchange="this.form.submit()" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                        </div>

                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                            <select id="status" name="status" onchange="this.form.submit()" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="">Semua</option>
                                <option value="Diproses" @selected($status === 'Diproses')>Proses</option>
                                <option value="Selesai" @selected($status === 'Selesai')>Selesai</option>
                            </select>
                        </div>

                        <div>
                            <label for="limit" class="mb-2 block text-sm font-medium text-slate-700">Limit</label>
                            <select id="limit" name="limit" onchange="this.form.submit()" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="10" @selected($limit === 10)>10</option>
                                <option value="20" @selected($limit === 20)>20</option>
                                <option value="50" @selected($limit === 50)>50</option>
                                <option value="100" @selected($limit === 100)>100</option>
                            </select>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2 md:col-span-2 xl:col-span-3">
                            <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                Cari
                            </button>
                            <a href="{{ route('helpdesk-log.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                Reset
                            </a>
                            <a href="{{ route('helpdesk-log.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                Download CSV
                            </a>
                            <div x-data="{ importOpen: false }">
                                <button @click="importOpen = true" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                    Import CSV
                                </button>

                                {{-- Import Modal --}}
                                <div x-show="importOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" @click.self="importOpen = false">
                                    <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-lg">
                                        <h2 class="text-lg font-semibold text-slate-900">Import Helpdesk dari CSV</h2>
                                        <p class="mt-2 text-sm text-slate-500">Kolom yang dibutuhkan: <span class="font-medium">Tanggal, Domain, Pelapor, Kontak, Email, Jenis Layanan, Kanal, Deskripsi, Status, Catatan Tambahan</span>. Baris pertama harus header.</p>

                                        <form method="POST" action="{{ route('helpdesk-log.import') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                                            @csrf
                                            <div>
                                                <label class="mb-2 block text-sm font-medium text-slate-700">File CSV</label>
                                                <input type="file" name="csv_file" accept=".csv,.txt" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition file:mr-3 file:rounded-xl file:border-0 file:bg-sky-50 file:px-3 file:py-1 file:text-xs file:font-medium file:text-sky-700">
                                                @error('csv_file')
                                                    <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="flex gap-3 pt-2">
                                                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                                    Upload & Import
                                                </button>
                                                <button type="button" @click="importOpen = false" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-filter-card>

                    <x-table-card title="Helpdesk report list" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-2">Tanggal</div>
                            <div class="col-span-2">Domain</div>
                            <div class="col-span-2">Pelapor</div>
                            <div class="col-span-2">Jenis Layanan</div>
                            <div class="col-span-2">Petugas</div>
                            <div class="col-span-1">Status</div>
                            <div class="col-span-1">Aksi</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($logs as $log)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm">
                                    <div class="col-span-12 md:col-span-2 text-slate-600">{{ $log->created_at?->format('d M Y H:i') }}</div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->domain . ($log->domainRecord?->zone ?? '') ?: '-' }}</div>
                                    <div class="col-span-12 md:col-span-2">
                                        <div class="font-medium text-slate-900">{{ $log->pelapor_nama }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $log->pelapor_phone }}</div>
                                        <div class="mt-1">
                                            <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $log->kanal }}</span>
                                        </div>
                                    </div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->jenis_layanan }}</div>
                                    <div class="col-span-6 md:col-span-2 text-xs text-slate-500">{{ $log->user?->name ?? '-' }}</div>
                                    <div class="col-span-6 md:col-span-1">
                                        @if ($log->status === 'Diproses')
                                            <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700">Proses</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Selesai</span>
                                        @endif
                                    </div>
                                    <div class="col-span-6 md:col-span-1">
                                        <a href="{{ route('helpdesk-log.edit', $log->helpdesk_log_id) }}" class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-700">
                                            Edit
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="px-5 py-14 text-center text-sm text-slate-500">
                                    Data kosong. Pakai search/filter dulu.
                                </div>
                            @endforelse
                        </div>
                    </x-table-card>
</x-dashboard-shell>
