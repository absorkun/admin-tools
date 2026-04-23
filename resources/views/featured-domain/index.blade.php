<x-dashboard-shell title="Featured Domains" active="featured-domain">
    <div x-data="{ tab: '{{ $tab }}' }">

        {{-- Tab nav --}}
        <div class="mb-6 flex gap-2 border-b border-slate-200">
            <button
                @click="tab = 'expired'"
                :class="tab === 'expired' ? 'border-b-2 border-sky-500 text-sky-700' : 'text-slate-500 hover:text-slate-800'"
                class="px-5 py-3 text-sm font-medium transition"
            >
                Domain Expired
                <span class="ml-1.5 rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-700">{{ $expiredDomains->count() }}</span>
            </button>
            <button
                @click="tab = 'inactive'"
                :class="tab === 'inactive' ? 'border-b-2 border-sky-500 text-sky-700' : 'text-slate-500 hover:text-slate-800'"
                class="px-5 py-3 text-sm font-medium transition"
            >
                Domain Tidak Aktif
                <span class="ml-1.5 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">{{ $inactiveDomains->count() }}</span>
            </button>
        </div>

        {{-- Shared filter --}}
        <x-filter-card :action="route('featured-domain.index')" class="grid gap-4 md:grid-cols-3">
            <input type="hidden" name="tab" :value="tab">
            <div>
                <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Cari Domain</label>
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
            <div class="flex flex-wrap items-end gap-3 pb-0.5">
                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                    Cari
                </button>
                <a href="{{ route('featured-domain.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                    Reset
                </a>
            </div>
        </x-filter-card>

        {{-- Tab: Expired --}}
        <div x-show="tab === 'expired'" x-cloak>
            <x-table-card title="Domain Expired" subtitle="Domain dengan tanggal kedaluwarsa sudah lewat." :count="$expiredDomains->count()">
                <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <div class="col-span-4">Domain</div>
                    <div class="col-span-3">Instansi</div>
                    <div class="col-span-2">Expires At</div>
                    <div class="col-span-2">Status</div>
                    <div class="col-span-1">Aksi</div>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse ($expiredDomains as $domain)
                        <article class="grid grid-cols-12 items-start gap-4 px-5 py-4 text-sm">
                            <div class="col-span-4 min-w-0">
                                <a href="{{ route('domain.show', $domain->id) }}" class="block truncate font-medium text-sky-700 hover:text-sky-500 hover:underline" title="{{ $domain->name . $domain->zone }}">{{ $domain->name . $domain->zone }}</a>
                                @if ($domain->phone)
                                    <div class="mt-0.5 text-xs text-slate-400">{{ $domain->phone }}</div>
                                @endif
                            </div>
                            <div class="col-span-3 text-slate-600">{{ $domain->nama_instansi ?? '-' }}</div>
                            <div class="col-span-2 text-xs text-rose-600">
                                {{ optional($domain->expires_at)->format('d M Y') ?? '-' }}
                            </div>
                            <div class="col-span-2">
                                @if ($domain->status === 'active')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Aktif</span>
                                @elseif ($domain->status === 'suspend')
                                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">Suspend</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">{{ ucfirst($domain->status ?? '-') }}</span>
                                @endif
                            </div>
                            <div class="col-span-1">
                                <a href="{{ route('domain.show', $domain->id) }}" class="inline-flex items-center rounded-xl border border-sky-200 bg-white px-3 py-1.5 text-xs font-medium text-sky-700 transition hover:border-sky-300 hover:bg-sky-50">
                                    Detail
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="px-5 py-14 text-center text-sm text-slate-500">Tidak ada domain expired.</div>
                    @endforelse
                </div>
            </x-table-card>
        </div>

        {{-- Tab: Inactive --}}
        <div x-show="tab === 'inactive'" x-cloak>
            <x-table-card title="Domain Tidak Aktif" subtitle="Domain dengan status selain aktif." :count="$inactiveDomains->count()">
                <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <div class="col-span-4">Domain</div>
                    <div class="col-span-3">Instansi</div>
                    <div class="col-span-2">Expires At</div>
                    <div class="col-span-2">Status</div>
                    <div class="col-span-1">Aksi</div>
                </div>
                <div class="divide-y divide-slate-200">
                    @forelse ($inactiveDomains as $domain)
                        <article class="grid grid-cols-12 items-start gap-4 px-5 py-4 text-sm">
                            <div class="col-span-4 min-w-0">
                                <a href="{{ route('domain.show', $domain->id) }}" class="block truncate font-medium text-sky-700 hover:text-sky-500 hover:underline" title="{{ $domain->name . $domain->zone }}">{{ $domain->name . $domain->zone }}</a>
                                @if ($domain->phone)
                                    <div class="mt-0.5 text-xs text-slate-400">{{ $domain->phone }}</div>
                                @endif
                            </div>
                            <div class="col-span-3 text-slate-600">{{ $domain->nama_instansi ?? '-' }}</div>
                            <div class="col-span-2 text-xs text-slate-500">
                                {{ optional($domain->expires_at)->format('d M Y') ?? '-' }}
                            </div>
                            <div class="col-span-2">
                                @if ($domain->status === 'suspend')
                                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">Suspend</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">{{ ucfirst($domain->status ?? '-') }}</span>
                                @endif
                            </div>
                            <div class="col-span-1">
                                <a href="{{ route('domain.show', $domain->id) }}" class="inline-flex items-center rounded-xl border border-sky-200 bg-white px-3 py-1.5 text-xs font-medium text-sky-700 transition hover:border-sky-300 hover:bg-sky-50">
                                    Detail
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="px-5 py-14 text-center text-sm text-slate-500">Tidak ada domain tidak aktif.</div>
                    @endforelse
                </div>
            </x-table-card>
        </div>

    </div>
</x-dashboard-shell>
