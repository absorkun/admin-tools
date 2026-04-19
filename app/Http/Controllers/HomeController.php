<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\EmailLogExpired;
use App\Models\HelpdeskLog;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $today = today();
        $thirtyDays = $today->copy()->addDays(30);

        // 1 query: all domain counts via conditional aggregation
        $domainStats = Domain::query()
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(status = 'active') as active")
            ->selectRaw("sum(status = 'suspend') as suspend")
            ->selectRaw('sum(expired_date is not null and expired_date < ?) as expired', [$today])
            ->selectRaw('sum(expires_at is not null and expires_at between ? and ?) as expiring_soon', [$today, $thirtyDays])
            ->first();

        // 1 query: all email log counts via conditional aggregation
        $emailStats = EmailLogExpired::query()
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(status = 'Ok') as ok")
            ->selectRaw('sum(tanggal = ?) as total_today', [$today])
            ->selectRaw("sum(status = 'Ok' and tanggal = ?) as ok_today", [$today])
            ->first();

        // 1 query: all helpdesk counts via conditional aggregation
        $helpdeskStats = HelpdeskLog::query()
            ->selectRaw('count(*) as total')
            ->selectRaw('sum(status = ?) as proses', [HelpdeskLog::STATUS_DIPROSES])
            ->selectRaw('sum(status = ?) as selesai', [HelpdeskLog::STATUS_SELESAI])
            ->first();

        $stats = [
            'total' => (int) $domainStats->total,
            'active' => (int) $domainStats->active,
            'expired' => (int) $domainStats->expired,
            'expiringSoon' => (int) $domainStats->expiring_soon,
            'suspend' => (int) $domainStats->suspend,
            'emailLogToday' => (int) $emailStats->total_today,
            'emailLogTotal' => (int) $emailStats->total,
            'emailLogOk' => (int) $emailStats->ok,
            'emailLogOkToday' => (int) $emailStats->ok_today,
            'helpdeskTotal' => (int) $helpdeskStats->total,
            'helpdeskProses' => (int) $helpdeskStats->proses,
            'helpdeskSelesai' => (int) $helpdeskStats->selesai,
        ];

        $recentExpired = Domain::query()
            ->select(['id', 'name', 'zone', 'status', 'expired_date'])
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<', today())
            ->orderByDesc('expired_date')
            ->limit(5)
            ->get();

        $upcomingExpiry = Domain::query()
            ->select(['id', 'name', 'zone', 'expires_at'])
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [today(), today()->addDays(30)])
            ->orderBy('expires_at')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentExpired' => $recentExpired,
            'upcomingExpiry' => $upcomingExpiry,
        ]);
    }

    public function landing(): View
    {
        return view('welcome');
    }
}
