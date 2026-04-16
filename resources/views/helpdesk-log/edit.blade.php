<x-dashboard-shell title="Edit Laporan" active="helpdesk-log">
                    <x-page-hero
                        eyebrow="Helpdesk"
                        title="Edit laporan #{{ $log->helpdesk_log_id }}"
                        description="Update status dan catatan admin untuk laporan ini."
                    />

                    <x-panel-card>
                        <form method="POST" action="{{ route('helpdesk-log.update', $log->helpdesk_log_id) }}" class="space-y-6">
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
                                    <label for="pelapor_nama" class="mb-2 block text-sm font-medium text-slate-700">Nama Pelapor</label>
                                    <input id="pelapor_nama" name="pelapor_nama" type="text" value="{{ old('pelapor_nama', $log->pelapor_nama) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                                </div>

                                <div>
                                    <label for="pelapor_phone" class="mb-2 block text-sm font-medium text-slate-700">Nomor Kontak</label>
                                    <input id="pelapor_phone" name="pelapor_phone" type="text" value="{{ old('pelapor_phone', $log->pelapor_phone) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                                </div>

                                <div>
                                    <label for="pelapor_email" class="mb-2 block text-sm font-medium text-slate-700">Email (opsional)</label>
                                    <input id="pelapor_email" name="pelapor_email" type="email" value="{{ old('pelapor_email', $log->pelapor_email) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                                </div>

                                <div>
                                    <label for="domain" class="mb-2 block text-sm font-medium text-slate-700">Nama Domain</label>
                                    <input id="domain" name="domain" type="text" value="{{ old('domain', $log->domain) }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">
                                </div>

                                <div>
                                    <label for="jenis_layanan" class="mb-2 block text-sm font-medium text-slate-700">Jenis Layanan</label>
                                    <select id="jenis_layanan" name="jenis_layanan" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        @foreach (\App\Models\HelpdeskLog::JENIS_LAYANAN as $jl)
                                            <option value="{{ $jl }}" @selected(old('jenis_layanan', $log->jenis_layanan) === $jl)>{{ $jl }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="kanal" class="mb-2 block text-sm font-medium text-slate-700">Kanal</label>
                                    <select id="kanal" name="kanal" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        @foreach (\App\Models\HelpdeskLog::KANAL as $k)
                                            <option value="{{ $k }}" @selected(old('kanal', $log->kanal) === $k)>{{ $k }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                                    <select id="status" name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                        <option value="Diproses" @selected(old('status', $log->status) === 'Diproses')>Proses</option>
                                        <option value="Selesai" @selected(old('status', $log->status) === 'Selesai')>Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300">{{ old('deskripsi', $log->deskripsi) }}</textarea>
                            </div>

                            <div>
                                <label for="catatan_tambahan" class="mb-2 block text-sm font-medium text-slate-700">Catatan Tambahan</label>
                                <textarea id="catatan_tambahan" name="catatan_tambahan" rows="4" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-300" placeholder="Tambah catatan...">{{ old('catatan_tambahan', $log->catatan_tambahan) }}</textarea>
                            </div>

                            <div class="space-y-2 text-xs text-slate-400">
                                <div>Dicatat oleh: {{ $log->user?->name ?? '-' }}</div>
                                <div>Tanggal: {{ $log->created_at?->format('d M Y H:i') }}</div>
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
