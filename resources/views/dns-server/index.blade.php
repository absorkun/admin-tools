<x-dashboard-shell title="DNS Server" active="dns-server">
                    <x-page-hero
                        eyebrow="DNS server"
                        title="Kelola domain DNS"
                        description="Search domain, user, atau DNS. Limit tampil bisa diatur. No filter ribet."
                    >
                        <x-slot:aside>
                            <div class="grid grid-cols-2 gap-3">
                                <x-stat-card label="Total" :value="$stats['total']" hint="Semua domain" />
                                <x-stat-card label="Active" :value="$stats['active']" hint="Status active" />
                                <x-stat-card label="Expired" :value="$stats['expired']" hint="Sudah lewat" />
                                <x-stat-card label="Suspend" :value="$stats['suspend']" hint="Sudah suspend" />
                            </div>
                        </x-slot:aside>
                    </x-page-hero>

                    <x-filter-card :action="route('dns-server.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-[1fr_10rem_auto]">
                        <div class="md:col-span-2 xl:col-span-1">
                            <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                            <input id="search" name="search" value="{{ $search }}" type="text" placeholder="Domain, name, dns_a, website" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
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

                        <div class="flex items-end gap-3 pt-2 md:col-span-2 xl:col-span-1">
                            <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                Apply filter
                            </button>
                            <a href="{{ route('dns-server.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                Reset
                            </a>
                            <a href="{{ route('dns-server.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                Download CSV
                            </a>
                        </div>
                    </x-filter-card>

                    <x-table-card title="DNS server list" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-4">Domain</div>
                            <div class="col-span-3">Owner</div>
                            <div class="col-span-2">Status</div>
                            <div class="col-span-1">Exp</div>
                            <div class="col-span-1">Email</div>
                            <div class="col-span-1">Action</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($domains as $domain)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm">
                                    <div class="col-span-12 md:col-span-4">
                                        <div class="font-medium text-slate-900">{{ $domain->domain }}</div>
                                        <div class="mt-1 break-all text-xs text-slate-500">{{ $domain->name_srv ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-12 md:col-span-3">
                                        <div class="font-medium text-slate-800">{{ $domain->user?->name ?? '-' }}</div>
                                        <div class="mt-1 break-all text-xs text-slate-500">{{ $domain->user?->email ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        @php($statusText = strtolower((string) $domain->status))
                                        @if ($statusText === 'active')
                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Active</span>
                                        @elseif ($statusText === 'suspend')
                                            <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">Suspend</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">{{ $domain->status ?? 'Expired' }}</span>
                                        @endif
                                    </div>
                                    <div class="col-span-6 md:col-span-1 text-slate-600">{{ $domain->tgl_exp?->format('d M Y') }}</div>
                                    <div class="col-span-6 md:col-span-1 text-slate-600">{{ $domain->tgl_email?->format('d M Y') }}</div>
                                    <div class="col-span-6 md:col-span-1">
                                        <a href="{{ route('email-log-expired.index', ['search' => $domain->domain]) }}" class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-700">
                                            Log
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
