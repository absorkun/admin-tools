<x-dashboard-shell title="Activity Log" active="activity-log">
                    <x-filter-card :action="route('activity-log.index')" class="grid gap-4 md:grid-cols-2 xl:grid-cols-2">
                        <div>
                            <label for="subject_type" class="mb-2 block text-sm font-medium text-slate-700">Subject</label>
                            <select id="subject_type" name="subject_type" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-300">
                                <option value="">Semua</option>
                                @foreach ($subjectTypes as $type)
                                    <option value="{{ $type }}" @selected($subjectType === $type)>{{ class_basename($type) }}</option>
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

                        <div class="flex items-end gap-3 pt-2 md:col-span-2">
                            <button type="submit" class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-sky-400">
                                Apply filter
                            </button>
                            <a href="{{ route('activity-log.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-sky-200 hover:text-sky-700">
                                Reset
                            </a>
                            <a href="{{ route('activity-log.export', request()->query()) }}" class="rounded-2xl border border-sky-200 bg-sky-50 px-5 py-3 text-sm font-medium text-sky-800 transition hover:bg-sky-100">
                                Download CSV
                            </a>
                        </div>
                    </x-filter-card>

                    <x-table-card title="Activity log list" subtitle="Hasil filter aktif.">
                        <div class="grid grid-cols-12 gap-4 border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <div class="col-span-2">Waktu</div>
                            <div class="col-span-2">User</div>
                            <div class="col-span-2">Event</div>
                            <div class="col-span-2">Subject</div>
                            <div class="col-span-4">Perubahan</div>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($logs as $log)
                                <article class="grid grid-cols-12 gap-4 px-5 py-4 text-sm">
                                    <div class="col-span-6 md:col-span-2 text-slate-600">
                                        {{ $log->created_at?->format('d M Y H:i') }}
                                    </div>
                                    <div class="col-span-6 md:col-span-2 text-slate-900">
                                        {{ $log->causer?->name ?? 'System' }}
                                    </div>
                                    <div class="col-span-6 md:col-span-2">
                                        @if ($log->description === 'created')
                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Created</span>
                                        @elseif ($log->description === 'updated')
                                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">Updated</span>
                                        @elseif ($log->description === 'deleted')
                                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Deleted</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">{{ ucfirst($log->description) }}</span>
                                        @endif
                                    </div>
                                    <div class="col-span-6 md:col-span-2 text-slate-600">
                                        {{ class_basename($log->subject_type ?? '-') }} #{{ $log->subject_id }}
                                    </div>
                                    <div class="col-span-12 md:col-span-4">
                                        @if ($log->attribute_changes && isset($log->attribute_changes['attributes']))
                                            <div class="space-y-1 text-xs">
                                                @foreach ($log->attribute_changes['attributes'] as $key => $value)
                                                    <div class="flex gap-2">
                                                        <span class="font-medium text-slate-700">{{ $key }}:</span>
                                                        @if (isset($log->attribute_changes['old'][$key]))
                                                            <span class="text-red-500 line-through">{{ $log->attribute_changes['old'][$key] ?? 'null' }}</span>
                                                            <span class="text-slate-400">&rarr;</span>
                                                        @endif
                                                        <span class="text-emerald-700">{{ $value ?? 'null' }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="px-5 py-14 text-center text-sm text-slate-500">
                                    Belum ada activity log.
                                </div>
                            @endforelse
                        </div>
                    </x-table-card>
</x-dashboard-shell>
