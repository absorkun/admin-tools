<?php

namespace App\Http\Controllers;

use App\Models\DnsServer;
use App\Models\EmailLogExpired;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total' => DnsServer::query()->count(),
            'active' => DnsServer::query()->whereRaw('LOWER(COALESCE(status, "")) = ?', ['active'])->count(),
            'expired' => DnsServer::query()->whereNotNull('tgl_exp')->whereDate('tgl_exp', '<', today())->count(),
            'expiringSoon' => DnsServer::query()->whereNotNull('tgl_exp')->whereBetween('tgl_exp', [today(), today()->addDays(30)])->count(),
            'withEmail' => DnsServer::query()->whereNotNull('tgl_email')->count(),
            'withNotifications' => DnsServer::query()->where('jumlah_notif', '>', 0)->count(),
            'suspend' => DnsServer::query()->whereRaw('LOWER(COALESCE(status, "")) = ?', ['suspend'])->count(),
            'suspendReady' => DnsServer::query()
                ->whereNotNull('tgl_exp')
                ->whereDate('tgl_exp', '<', today())
                ->whereNotNull('tgl_email')
                ->whereDate('tgl_email', '<=', today()->subDays(14))
                ->where(function ($q): void {
                    $q->whereNull('status')
                        ->orWhereRaw('LOWER(status) != ?', ['suspend']);
                })
                ->count(),
            'emailLogToday' => EmailLogExpired::query()->whereDate('tanggal', today())->count(),
        ];

        $recentExpired = DnsServer::query()
            ->select(['domain', 'users_id', 'status', 'tgl_exp'])
            ->with('user:id,email')
            ->whereNotNull('tgl_exp')
            ->whereDate('tgl_exp', '<', today())
            ->orderByDesc('tgl_exp')
            ->limit(5)
            ->get();

        $upcomingExpiry = DnsServer::query()
            ->select(['domain', 'users_id', 'tgl_exp'])
            ->with('user:id,email')
            ->whereNotNull('tgl_exp')
            ->whereBetween('tgl_exp', [today(), today()->addDays(30)])
            ->orderBy('tgl_exp')
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
