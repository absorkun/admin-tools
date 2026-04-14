@props(['label', 'value', 'hint'])

<article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50">
    <div class="text-sm text-slate-500">{{ $label }}</div>
    <div class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $value }}</div>
    <div class="mt-2 text-sm text-slate-500">{{ $hint }}</div>
</article>
