<x-dashboard-shell title="Helpdesk Log" active="helpdesk-log">
                    <x-page-hero
                        eyebrow="Helpdesk"
                        title="Log laporan helpdesk"
                        description="Catat semua laporan masuk dari WhatsApp, email, atau telepon. Filter dan export kapan saja."
                    >
                        <x-slot:aside>
                            <div class="grid grid-cols-3 gap-3">
                                <x-stat-card label="Total" :value="$stats['total']" hint="Semua laporan" />
                                <x-stat-card label="Proses" :value="$stats['proses']" hint="Sedang ditangani" />
                                <x-stat-card label="Selesai" :value="$stats['selesai']" hint="Sudah selesai" />
                            </div>
                        </x-slot:aside>
                    </x-page-hero>

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
                        <div class="md:col-span-2 xl:col-span-3">
                            <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                            <input id="search" name="search" value="{{ $search }}" type="text" placeholder="Domain, pelapor, isi laporan" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                        </div>

                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                            <select id="status" name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="">Semua</option>
                                <option value="Diproses" @selected($status === 'Diproses')>Proses</option>
                                <option value="Selesai" @selected($status === 'Selesai')>Selesai</option>
                            </select>
                        </div>

                        <div>
                            <label for="limit" class="mb-2 block text-sm font-medium text-slate-700">Limit</label>
                            <select id="limit" name="limit" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="10" @selected($limit === 10)>10</option>
                                <option value="20" @selected($limit === 20)>20</option>
                                <option value="50" @selected($limit === 50)>50</option>
                                <option value="100" @selected($limit === 100)>100</option>
                            </select>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2 md:col-span-2 xl:col-span-3">
                            <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                Apply filter
                            </button>
                            <a href="{{ route('helpdesk-log.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                Reset
                            </a>
                            <a href="{{ route('helpdesk-log.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                Download CSV
                            </a>
                        </div>
                    </x-filter-card>

                    <x-table-card title="Helpdesk log list" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-2">Pelapor</div>
                            <div class="col-span-2">Domain</div>
                            <div class="col-span-2">Jenis Layanan</div>
                            <div class="col-span-1">Kanal</div>
                            <div class="col-span-1">Status</div>
                            <div class="col-span-1">Agent</div>
                            <div class="col-span-2">Tanggal</div>
                            <div class="col-span-1">Action</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($logs as $log)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm">
                                    <div class="col-span-12 md:col-span-2">
                                        <div class="font-medium text-slate-900">{{ $log->pelapor_nama }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $log->pelapor_phone }}</div>
                                    </div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->domain ?? '-' }}</div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->jenis_layanan }}</div>
                                    <div class="col-span-6 md:col-span-1">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                            {{ $log->kanal }}
                                        </span>
                                    </div>
                                    <div class="col-span-6 md:col-span-1">
                                        @if ($log->status === 'Diproses')
                                            <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700">Proses</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Selesai</span>
                                        @endif
                                    </div>
                                    <div class="col-span-6 md:col-span-1 text-xs text-slate-500">{{ $log->user?->name ?? '-' }}</div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->created_at?->format('d M Y H:i') }}</div>
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
