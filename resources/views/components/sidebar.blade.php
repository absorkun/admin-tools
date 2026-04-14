@props(['active' => 'dashboard'])

<aside class="flex h-screen flex-col border-r border-slate-200 bg-white/90 px-5 py-6">
    <div class="mb-8 shrink-0">
        <div class="text-xs uppercase tracking-[0.28em] text-sky-600">Domain Admin</div>
        <div class="mt-2 text-lg font-semibold text-slate-900">Control Panel</div>
    </div>

    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" class="{{ $active === 'dashboard' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Dashboard
        </a>
        <a href="{{ route('dns-server.index') }}" class="{{ $active === 'dns-server' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            DNS Server
        </a>
        <a href="{{ route('email-log-expired.index') }}" class="{{ $active === 'email-log-expired' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Email Log
        </a>
        <a href="{{ route('suspend-queue.index') }}" class="{{ $active === 'suspend-queue' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Suspend Queue
        </a>
        <a href="{{ route('helpdesk-log.index') }}" class="{{ $active === 'helpdesk-log' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Helpdesk Log
        </a>
    </nav>

    <div class="mt-auto shrink-0 rounded-2xl border border-slate-200 bg-slate-50 p-4">
        <div class="text-sm font-medium text-slate-900">Internal access</div>
        <p class="mt-2 text-sm leading-6 text-slate-500">Panel ini khusus tim domain. Fokus data, bukan dekorasi.</p>
    </div>
</aside>
