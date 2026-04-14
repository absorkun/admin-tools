<x-dashboard-shell title="Dashboard" active="dashboard">
                    <x-page-hero
                        eyebrow="Statistik DNS"
                        title="Ringkasan operasi domain"
                        description="Statistik real-time dari tabel dns_server dan email_log_expired. Data diambil langsung, tanpa cache."
                    >
                        <x-slot:aside>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Active</div>
                                    <div class="mt-1 text-2xl font-semibold text-emerald-600">{{ $stats['active'] }}</div>
                                </div>
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Expired</div>
                                    <div class="mt-1 text-2xl font-semibold text-amber-600">{{ $stats['expired'] }}</div>
                                </div>
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Suspend</div>
                                    <div class="mt-1 text-2xl font-semibold text-rose-600">{{ $stats['suspend'] }}</div>
                                </div>
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Total</div>
                                    <div class="mt-1 text-2xl font-semibold text-slate-900">{{ $stats['total'] }}</div>
                                </div>
                            </div>
                        </x-slot:aside>
                    </x-page-hero>

                    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <x-stat-card label="Akan expired 30 hari" :value="$stats['expiringSoon']" hint="Perlu follow-up cepat" />
                        <x-stat-card label="Siap suspend" :value="$stats['suspendReady']" hint="Expired 14+ hari sejak email" />
                        <x-stat-card label="Email log hari ini" :value="$stats['emailLogToday']" hint="Email terkirim hari ini" />
                        <x-stat-card label="Notif jalan" :value="$stats['withNotifications']" hint="jumlah_notif lebih dari 0" />
                    </section>

                    <section class="grid gap-6 xl:grid-cols-2">
                        <x-panel-card>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Baru expired</h2>
                                <a href="{{ route('dns-server.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">Lihat semua →</a>
                            </div>
                            <div class="mt-4 space-y-2">
                                @forelse ($recentExpired as $domain)
                                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                        <div>
                                            <span class="font-medium text-slate-900">{{ $domain->domain }}</span>
                                            <span class="ml-2 text-xs text-slate-500">{{ $domain->user?->email ?? '-' }}</span>
                                        </div>
                                        <span class="text-xs text-amber-600">{{ $domain->tgl_exp?->format('d M Y') }}</span>
                                    </div>
                                @empty
                                    <p class="py-4 text-center text-sm text-slate-500">Belum ada domain expired.</p>
                                @endforelse
                            </div>
                        </x-panel-card>

                        <x-panel-card>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Segera expired</h2>
                                <a href="{{ route('dns-server.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">Lihat semua →</a>
                            </div>
                            <div class="mt-4 space-y-2">
                                @forelse ($upcomingExpiry as $domain)
                                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                        <div>
                                            <span class="font-medium text-slate-900">{{ $domain->domain }}</span>
                                            <span class="ml-2 text-xs text-slate-500">{{ $domain->user?->email ?? '-' }}</span>
                                        </div>
                                        <span class="text-xs text-rose-600">{{ $domain->tgl_exp?->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <p class="py-4 text-center text-sm text-slate-500">Tidak ada yang akan expired dalam 30 hari.</p>
                                @endforelse
                            </div>
                        </x-panel-card>
                    </section>

                    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <a href="{{ route('dns-server.index') }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50 transition hover:border-sky-200 hover:shadow-md">
                            <div class="text-sm font-medium text-sky-600">DNS Server</div>
                            <p class="mt-2 text-xs leading-5 text-slate-500">Kelola domain, cari DNS, download CSV</p>
                        </a>
                        <a href="{{ route('email-log-expired.index') }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50 transition hover:border-sky-200 hover:shadow-md">
                            <div class="text-sm font-medium text-sky-600">Email Log</div>
                            <p class="mt-2 text-xs leading-5 text-slate-500">Cek log email expired per domain</p>
                        </a>
                        <a href="{{ route('suspend-queue.index') }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50 transition hover:border-sky-200 hover:shadow-md">
                            <div class="text-sm font-medium text-sky-600">Suspend Queue</div>
                            <p class="mt-2 text-xs leading-5 text-slate-500">Domain siap suspend, satu klik proses</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50 transition hover:border-sky-200 hover:shadow-md">
                            <div class="text-sm font-medium text-sky-600">Profile</div>
                            <p class="mt-2 text-xs leading-5 text-slate-500">Ubah nama, email, password, foto</p>
                        </a>
                    </section>
</x-dashboard-shell>
