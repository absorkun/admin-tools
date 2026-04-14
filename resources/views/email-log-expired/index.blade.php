<x-dashboard-shell title="Email Log Expired" active="email-log-expired">
                    <x-page-hero
                        eyebrow="Email log"
                        title="Email log expired"
                        description="Cari data by domain, email, status, atau rentang tanggal. Halaman ini fokus ke filter, bukan dump semua baris."
                    >
                        <x-slot:aside>
                            <div class="grid grid-cols-2 gap-3">
                                <x-stat-card label="Total" :value="$stats['total']" hint="Semua baris email log" />
                                <x-stat-card label="Ok" :value="$stats['ok']" hint="Status ok" />
                                <x-stat-card label="Total Today" :value="$stats['total_today']" hint="Semua email log hari ini" />
                                <x-stat-card label="Ok Today" :value="$stats['ok_today']" hint="Status ok hari ini" />
                            </div>
                        </x-slot:aside>
                    </x-page-hero>

                    <x-filter-card :action="route('email-log-expired.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                            <div class="xl:col-span-2">
                                <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                                <input id="search" name="search" value="{{ $search }}" type="text" placeholder="domain / email / status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                            </div>

                            <div>
                                <label for="period" class="mb-2 block text-sm font-medium text-slate-700">Periode</label>
                                <select id="period" name="period" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                    <option value="today" @selected($period === 'today')>Hari ini</option>
                                    <option value="7_days" @selected($period === '7_days')>7 Hari Lalu</option>
                                    <option value="custom" @selected($period === 'custom')>Custom</option>
                                </select>
                            </div>

                            <div>
                                <label for="limit" class="mb-2 block text-sm font-medium text-slate-700">Limit</label>
                                <select id="limit" name="limit" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                    <option value="10" @selected($limit === 10)>10</option>
                                    <option value="20" @selected($limit === 20 || $limit === null)>20</option>
                                    <option value="50" @selected($limit === 50)>50</option>
                                    <option value="100" @selected($limit === 100)>100</option>
                                    <option value="all" @selected($limit === null && request('limit') === 'all')>Semua</option>
                                </select>
                            </div>

                            <div>
                                <label for="date_from" class="mb-2 block text-sm font-medium text-slate-700">Dari</label>
                                <input id="date_from" name="date_from" value="{{ $dateFrom }}" type="date" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                            </div>

                            <div>
                                <label for="date_to" class="mb-2 block text-sm font-medium text-slate-700">Sampai</label>
                                <input id="date_to" name="date_to" value="{{ $dateTo }}" type="date" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                            </div>

                            <div class="md:col-span-2 xl:col-span-6 flex flex-wrap items-center gap-3 pt-2">
                                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                    Apply filter
                                </button>
                                <a href="{{ route('email-log-expired.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                    Reset
                                </a>
                                <a href="{{ route('email-log-expired.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                    Download CSV
                                </a>
                                <span class="text-sm text-slate-500">Default 20 hasil. Limit bisa semua, 10, 20, 50, atau 100.</span>
                            </div>
                    </x-filter-card>

                    <x-table-card title="Email log list" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-4">Domain</div>
                            <div class="col-span-2">Tanggal</div>
                            <div class="col-span-2">Expired</div>
                            <div class="col-span-2">Selisih</div>
                            <div class="col-span-2">Status</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($logs as $log)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm">
                                    <div class="col-span-12 md:col-span-4">
                                        <div class="font-medium text-slate-900">{{ $log->domain }}</div>
                                        <div class="mt-1 text-xs text-slate-500 break-all">{{ $log->email }}</div>
                                        <div class="mt-2 text-xs text-slate-400">ID {{ $log->email_log_id }}</div>
                                    </div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->tanggal?->format('d M Y H:i') }}</div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $log->tgl_exp?->format('d M Y') }}</div>
                                    <div class="col-span-6 md:col-span-2">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                            {{ $log->selisih }}
                                        </span>
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-700">
                                            {{ $log->status ?? '-' }}
                                        </span>
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
