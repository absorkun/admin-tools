<x-dashboard-shell title="DNS Server — {{ $dnsServer->domain }}" active="dns-server">
                    <x-page-hero
                        eyebrow="DNS server"
                        title="{{ $dnsServer->domain }}"
                        description="Detail lengkap domain beserta log email expired."
                    />

                    <div class="flex">
                        <a href="{{ route('dns-server.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                            &larr; Kembali
                        </a>
                    </div>

                    {{-- 1. Informasi Domain --}}
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-lg font-semibold text-slate-900">Informasi Domain</h2>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <x-detail-field label="Domain" :value="$dnsServer->domain" />
                            <x-detail-field label="Name Server" :value="$dnsServer->name_srv ?? '-'" />
                            <x-detail-field label="DNS A" :value="$dnsServer->dns_a ?? '-'" />
                            <x-detail-field label="Website" :value="$dnsServer->website ?? '-'" />
                            <x-detail-field label="DNSSEC" :value="$dnsServer->dnssec ? 'Enabled' : 'Disabled'" />
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Status</dt>
                                <dd class="mt-1">
                                    @php($statusText = strtolower((string) $dnsServer->status))
                                    @if ($statusText === 'active')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Active</span>
                                    @elseif ($statusText === 'suspend')
                                        <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">Suspend</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">{{ $dnsServer->status ?? 'Expired' }}</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Kontak User --}}
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-lg font-semibold text-slate-900">Kontak User</h2>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <x-detail-field label="Nama" :value="$dnsServer->user?->name ?? '-'" />
                            <x-detail-field label="Email" :value="$dnsServer->user?->email ?? '-'" />
                            <x-detail-field label="User ID" :value="$dnsServer->users_id ?? '-'" />
                            <x-detail-field label="Domain ID" :value="$dnsServer->domains_id ?? '-'" />
                        </div>
                    </div>

                    {{-- 3. Lainnya --}}
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-lg font-semibold text-slate-900">Lainnya</h2>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <x-detail-field label="Tgl Registrasi" :value="$dnsServer->tgl_reg?->format('d M Y') ?? '-'" />
                            <x-detail-field label="Tgl Expired" :value="$dnsServer->tgl_exp?->format('d M Y') ?? '-'" />
                            <x-detail-field label="Tgl Update" :value="$dnsServer->tgl_upd?->format('d M Y') ?? '-'" />
                            <x-detail-field label="Tgl Exp Domains" :value="$dnsServer->tgl_exp_domains?->format('d M Y') ?? '-'" />
                            <x-detail-field label="Tgl Email" :value="$dnsServer->tgl_email?->format('d M Y') ?? '-'" />
                            <x-detail-field label="Jumlah Notif" :value="$dnsServer->jumlah_notif ?? 0" />
                        </div>
                    </div>

</x-dashboard-shell>
