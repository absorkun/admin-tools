@props(['title', 'subtitle' => null, 'count' => null])

<x-panel-card class="overflow-hidden p-0">
    <div class="border-b border-slate-200 px-6 py-4">
        <div class="flex items-center gap-3">
            <h2 class="text-lg font-semibold text-slate-900">{{ $title }}</h2>
            @if($count !== null)
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">{{ $count }} baris</span>
            @endif
        </div>
        @if($subtitle)
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="overflow-hidden">
        {{ $slot }}
    </div>
</x-panel-card>
