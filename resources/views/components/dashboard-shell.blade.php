@props(['title' => null, 'active' => 'dashboard'])

<x-layouts.app :title="$title">
    <div class="grid min-h-screen lg:grid-cols-[18rem_1fr]">
        <x-sidebar :active="$active" />

        <div class="flex min-w-0 flex-col bg-stone-100">
            <x-topbar>{{ $title }}</x-topbar>

            <main class="flex-1 px-6 py-8">
                <div class="max-w-7xl space-y-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-layouts.app>
