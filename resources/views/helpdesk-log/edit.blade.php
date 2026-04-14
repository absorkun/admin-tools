<x-dashboard-shell title="Edit Laporan" active="helpdesk-log">
                    <x-page-hero
                        eyebrow="Helpdesk"
                        title="Edit laporan #{{ $log->helpdesk_log_id }}"
                        description="Update status dan catatan admin untuk laporan ini."
                    />

                    <x-panel-card>
                        <div class="space-y-4 border-b border-slate-200 pb-6">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Pelapor</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ $log->pelapor_nama }}</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Email pelapor</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ $log->pelapor_email }}</div>
                                </div>
                                @if ($log->pelapor_phone)
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Telepon pelapor</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ $log->pelapor_phone }}</div>
                                </div>
                                @endif
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Domain</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ $log->domain ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Sumber</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ ucfirst($log->sumber) }}</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Dicatat oleh</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ $log->user?->name ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Tanggal</div>
                                    <div class="mt-1 font-medium text-slate-900">{{ $log->created_at?->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Isi laporan</div>
                                <div class="mt-2 rounded-2xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">{{ $log->isi_laporan }}</div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('helpdesk-log.update', $log->helpdesk_log_id) }}" class="space-y-6 pt-6">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                    <ul class="list-inside list-disc space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                                    <select id="status" name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        <option value="baru" @selected(old('status', $log->status) === 'baru')>Baru</option>
                                        <option value="proses" @selected(old('status', $log->status) === 'proses')>Proses</option>
                                        <option value="selesai" @selected(old('status', $log->status) === 'selesai')>Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="catatan_admin" class="mb-2 block text-sm font-medium text-slate-700">Catatan admin</label>
                                <textarea id="catatan_admin" name="catatan_admin" rows="4" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Tambah catatan internal...">{{ old('catatan_admin', $log->catatan_admin) }}</textarea>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                    Update laporan
                                </button>
                                <a href="{{ route('helpdesk-log.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </x-panel-card>
</x-dashboard-shell>
