<x-dashboard-shell title="Domain" active="domain">
                    <x-filter-card :action="route('domain.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div>
                            <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Cari Domain</label>
                            <input id="search" name="search" value="{{ $search }}" type="text" placeholder="Nama domain" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                        </div>

                        <div>
                            <label for="zone" class="mb-2 block text-sm font-medium text-slate-700">Zone</label>
                            <select id="zone" name="zone" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="">Semua</option>
                                <option value=".go.id" @selected($zone === '.go.id')>.go.id</option>
                                <option value=".desa.id" @selected($zone === '.desa.id')>.desa.id</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                            <select id="status" name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="">Semua</option>
                                @foreach (['active', 'suspend', 'cancelled', 'reject', 'draft', 'error', 'verifikasi dokumen', 'pending payment', 'verifikasi pembayaran'] as $s)
                                    <option value="{{ $s }}" @selected(($status ?? '') === $s)>{{ ucfirst($s) }}</option>
                                @endforeach
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

                        <div class="flex flex-wrap items-center gap-3 pt-2 md:col-span-2 xl:col-span-4">
                            <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                Terapkan
                            </button>
                            <a href="{{ route('domain.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                Reset
                            </a>
                            <a href="{{ route('domain.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                Download CSV
                            </a>
                        </div>
                    </x-filter-card>

                    <x-table-card title="Daftar domain" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-4">Domain</div>
                            <div class="col-span-4">Nameserver</div>
                            <div class="col-span-2">Status</div>
                            <div class="col-span-2">Aksi</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($domains as $domain)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm items-start">
                                    <div class="col-span-12 md:col-span-4 min-w-0">
                                        <a href="{{ route('domain.show', $domain->id) }}" class="block truncate font-medium text-sky-700 hover:text-sky-500 hover:underline" title="{{ $domain->name . $domain->zone }}">{{ $domain->name . $domain->zone }}</a>
                                    </div>
                                    <div class="col-span-6 md:col-span-4 text-xs text-slate-500">
                                        @if ($domain->domain_name_server)
                                            @foreach ($domain->domain_name_server as $ns)
                                                <div>{{ $ns }}</div>
                                            @endforeach
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        @if ($domain->status === 'active')
                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Aktif</span>
                                        @elseif ($domain->status === 'suspend')
                                            <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">Suspend</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">{{ ucfirst($domain->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        <a href="{{ route('domain.show', $domain->id) }}" class="inline-flex items-center rounded-xl border border-sky-200 bg-white px-3 py-1.5 text-xs font-medium text-sky-700 transition hover:border-sky-300 hover:bg-sky-50">
                                            Detail
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="px-5 py-14 text-center text-sm text-slate-500">
                                    Data kosong. Coba ubah filter pencarian.
                                </div>
                            @endforelse
                        </div>
                    </x-table-card>
</x-dashboard-shell>
