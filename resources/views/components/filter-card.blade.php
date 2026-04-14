@props(['action', 'method' => 'GET'])

<x-panel-card>
    <form method="{{ $method }}" action="{{ $action }}" {{ $attributes->merge(['class' => 'grid gap-4']) }}>
        {{ $slot }}
    </form>
</x-panel-card>
