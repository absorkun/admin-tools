@props(['title' => null, 'active' => 'dashboard'])

<x-layouts.app :title="$title">
    <div x-data="{ sidebarOpen: false }" class="grid min-h-screen lg:grid-cols-[18rem_1fr]">
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-black/40 lg:hidden" @click="sidebarOpen = false"></div>

        {{-- Sidebar --}}
        <div
            x-cloak
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-72 transition-transform duration-200 lg:static lg:z-auto lg:translate-x-0 lg:w-auto"
        >
            <x-sidebar :active="$active" />
        </div>

        <div class="flex min-w-0 flex-col bg-stone-100">
            <x-topbar :sidebar-toggle="true">{{ $title }}</x-topbar>

            <main class="flex-1 px-6 py-8">
                <div class="max-w-7xl space-y-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-layouts.app>
