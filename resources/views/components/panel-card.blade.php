@props(['class' => ''])

<section {{ $attributes->class(['rounded-3xl border border-slate-200 bg-white p-6 shadow-sm shadow-sky-100/50', $class]) }}>
    {{ $slot }}
</section>
