<x-dashboard-shell title="Suspend Queue" active="suspend-queue">
                    <x-page-hero
                        eyebrow="Suspend ready"
                        title="Domain expired siap suspend"
                        description="Domain expired yang sudah 14 hari atau lebih sejak email terakhir."
                    />

                        @if (session('status'))
                            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                {{ session('status') }}
                            </div>
                        @endif

                    <x-filter-card :action="route('suspend-queue.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-[1fr_10rem_auto]">
                        <div class="md:col-span-2 xl:col-span-1">
                            <label for="search" class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                            <input id="search" name="search" value="{{ $search }}" type="text" placeholder="Cari domain" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                        </div>

                        <div>
                            <label for="limit" class="mb-2 block text-sm font-medium text-slate-700">Limit</label>
                            <select id="limit" name="limit" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                @foreach ([10, 20, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($limit === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end gap-3 pt-2 md:col-span-2 xl:col-span-1">
                            <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                Apply filter
                            </button>
                            <a href="{{ route('suspend-queue.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                Reset
                            </a>
                            <a href="{{ route('suspend-queue.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                Download CSV
                            </a>
                        </div>
                    </x-filter-card>

                    <x-table-card title="Domain list" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-3">Domain</div>
                            <div class="col-span-2">Status</div>
                            <div class="col-span-2">Expired</div>
                            <div class="col-span-2">Email sent</div>
                            <div class="col-span-1">Notif</div>
                            <div class="col-span-2">Action</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($domains as $domain)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm">
                                    <div class="col-span-12 md:col-span-3">
                                        <div class="font-medium text-slate-900">{{ $domain->domain }}</div>
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">Ready suspend</span>
                                    </div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $domain->tgl_exp?->format('d M Y') ?? '-' }}</div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">{{ $domain->tgl_email?->format('d M Y') ?? '-' }}</div>
                                    <div class="col-span-6 md:col-span-1 text-slate-600">{{ $domain->jumlah_notif ?? 0 }}</div>
                                    <div class="col-span-6 md:col-span-2">
                                        <form method="POST" action="{{ route('suspend-queue.suspend', $domain->domain) }}" onsubmit="return confirm('Suspend domain {{ $domain->domain }}?');">
                                            @csrf
                                            <button type="submit" class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-700">
                                                Suspend
                                            </button>
                                        </form>
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
