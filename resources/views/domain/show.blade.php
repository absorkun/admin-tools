<x-dashboard-shell title="Domain — {{ $domain->name . $domain->zone }}" active="domain">
                    <div class="flex">
                        <a href="{{ route('domain.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                            &larr; Kembali
                        </a>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <dl class="divide-y divide-slate-200">
                            {{-- Domain --}}
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Domain</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->name . $domain->zone }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Zone</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->zone }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Tipe</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ ucfirst($domain->type_domain ?? '-') }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Status</dt>
                                <dd class="mt-1">
                                    @if ($domain->status === 'active')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Aktif</span>
                                    @elseif ($domain->status === 'suspend')
                                        <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700">Suspend</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">{{ ucfirst($domain->status) }}</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Instansi</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->nama_instansi ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Organisasi</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->name_organization ?? '-' }}</dd>
                            </div>

                            {{-- Registrant --}}
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Registrant</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->registrant?->email ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Telepon</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->phone ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->address ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Kode Pos</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->postal_code ?? '-' }}</dd>
                            </div>

                            {{-- Nameserver --}}
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Nameserver</dt>
                                <dd class="mt-1 text-sm text-slate-900">
                                    @if ($domain->domain_name_server)
                                        @foreach ($domain->domain_name_server as $i => $ns)
                                            <div>{{ $ns }}@if ($domain->ns_country && isset($domain->ns_country[$i])) <span class="text-xs text-slate-500">({{ $domain->ns_country[$i] }})</span>@endif</div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>

                            {{-- Tanggal --}}
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Terdaftar</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->registered_at?->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Kedaluwarsa</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->expires_at?->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Tanggal Aktif</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->active_date?->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Tanggal Expired</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->expired_date?->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Tanggal Perpanjangan</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->renewal_date?->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="px-6 py-4">
                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Durasi</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $domain->duration ? $domain->duration . ' tahun' : '-' }}</dd>
                            </div>

                            {{-- Catatan --}}
                            @if ($domain->note)
                                <div class="px-6 py-4">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Catatan</dt>
                                    <dd class="mt-1 text-sm text-slate-900">{{ $domain->note }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

</x-dashboard-shell>
