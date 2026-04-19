<x-dashboard-shell title="Dashboard" active="dashboard">
                    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <x-stat-card label="Aktif" :value="$stats['active']" />
                        <x-stat-card label="Expired" :value="$stats['expired']" />
                        <x-stat-card label="Suspend" :value="$stats['suspend']" />
                        <x-stat-card label="Total" :value="$stats['total']" />
                    </section>

                    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        <x-stat-card label="Akan expired 30 hari" :value="$stats['expiringSoon']" />
                        <x-stat-card label="Email log hari ini" :value="$stats['emailLogToday']" />
                        <x-stat-card label="Email log total" :value="$stats['emailLogTotal']" />
                        <x-stat-card label="Email log Ok" :value="$stats['emailLogOk']" />
                        <x-stat-card label="Email log Ok hari ini" :value="$stats['emailLogOkToday']" />
                        <x-stat-card label="Helpdesk total" :value="$stats['helpdeskTotal']" />
                        <x-stat-card label="Helpdesk proses" :value="$stats['helpdeskProses']" />
                        <x-stat-card label="Helpdesk selesai" :value="$stats['helpdeskSelesai']" />
                    </section>

                    <section class="grid gap-6 xl:grid-cols-2">
                        <x-panel-card>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Baru expired</h2>
                                <a href="{{ route('domain.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">Lihat semua →</a>
                            </div>
                            <div class="mt-4 space-y-2">
                                @forelse ($recentExpired as $domain)
                                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                        <div>
                                            <span class="font-medium text-slate-900">{{ $domain->name }}</span>
                                        </div>
                                        <span class="text-xs text-amber-600">{{ $domain->expired_date?->format('d M Y') }}</span>
                                    </div>
                                @empty
                                    <p class="py-4 text-center text-sm text-slate-500">Belum ada domain expired.</p>
                                @endforelse
                            </div>
                        </x-panel-card>

                        <x-panel-card>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Segera expired</h2>
                                <a href="{{ route('domain.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">Lihat semua →</a>
                            </div>
                            <div class="mt-4 space-y-2">
                                @forelse ($upcomingExpiry as $domain)
                                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                        <div>
                                            <span class="font-medium text-slate-900">{{ $domain->name }}</span>
                                        </div>
                                        <span class="text-xs text-rose-600">{{ $domain->expires_at?->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <p class="py-4 text-center text-sm text-slate-500">Tidak ada yang akan expired dalam 30 hari.</p>
                                @endforelse
                            </div>
                        </x-panel-card>
                    </section>
</x-dashboard-shell>
