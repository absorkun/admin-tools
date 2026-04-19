@props(['active' => 'dashboard'])

<aside class="sticky top-0 flex h-screen flex-col border-r border-slate-200 bg-white px-5 py-6">
    <div class="mb-8 shrink-0">
        <div class="text-xs uppercase tracking-[0.28em] text-sky-600">Domain</div>
        <div class="mt-2 text-lg font-semibold text-slate-900">Admin Tools</div>
    </div>

    <nav class="space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="{{ $active === 'dashboard' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Dashboard
        </a>

        <div class="pb-1 pt-4 px-4 text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-slate-400">Data</div>
        <a href="{{ route('domain.index') }}" class="{{ $active === 'domain' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Domains
        </a>
        <a href="{{ route('email-log-expired.index') }}" class="{{ $active === 'email-log-expired' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Email Log
        </a>
        @hasanyrole('super_admin')
        <a href="{{ route('suspend-queue.index') }}" class="{{ $active === 'suspend-queue' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Suspend Queue
        </a>
        @endhasanyrole
        <a href="{{ route('helpdesk-log.index') }}" class="{{ $active === 'helpdesk-log' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Helpdesk Report
        </a>

        @hasanyrole('super_admin')
        <div class="pb-1 pt-4 px-4 text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-slate-400">System</div>
        <a href="{{ route('activity-log.index') }}" class="{{ $active === 'activity-log' ? 'bg-sky-50 text-sky-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} flex items-center rounded-xl px-4 py-3 text-sm font-medium transition">
            Activity Log
        </a>
        @endhasanyrole
    </nav>
</aside>
