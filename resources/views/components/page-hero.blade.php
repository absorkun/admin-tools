@props([
    'eyebrow',
    'title',
    'description',
])

<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50">
    <div class="grid gap-6 lg:grid-cols-[1.2fr_.8fr]">
        <div>
            <p class="text-sm uppercase tracking-[0.24em] text-sky-600">{{ $eyebrow }}</p>
            <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ $title }}</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">{{ $description }}</p>
        </div>

        {{ $aside ?? '' }}
    </div>
</section>
