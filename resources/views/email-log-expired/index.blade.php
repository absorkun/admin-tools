<x-dashboard-shell title="Email Log Expired" active="email-log-expired">
                    <x-filter-card :action="route('email-log-expired.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-2">
                            <div>
                                <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                                <input id="search" name="search" value="{{ $search }}" type="text" placeholder="Nama domain" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
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

                            <div class="md:col-span-2 flex flex-wrap items-center gap-3 pt-2">
                                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                    Cari
                                </button>
                                <a href="{{ route('email-log-expired.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                    Reset
                                </a>
                                <a href="{{ route('email-log-expired.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                    Download CSV
                                </a>
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
