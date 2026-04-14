<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\EmailLogExpired;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmailLogExpiredController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $period = $request->string('period')->toString();
        $dateFrom = $request->string('date_from')->toString();
        $dateTo = $request->string('date_to')->toString();
        $limitValue = $request->string('limit')->toString();
        $limit = $limitValue === 'all' ? null : ((in_array((int) $limitValue, [10, 20, 50, 100], true) ? (int) $limitValue : 20));

        $logs = $this->buildQuery($search, $period, $dateFrom, $dateTo, $limit)->get();

        $stats = [
            'total' => EmailLogExpired::query()->count(),
            'ok' => EmailLogExpired::query()->where('status', 'Ok')->count(),
            'total_today' => EmailLogExpired::query()->whereDate('tanggal', today())->count(),
            'ok_today' => EmailLogExpired::query()->where('status', 'Ok')->whereDate('tanggal', today())->count(),
        ];

        return view('email-log-expired.index', [
            'logs' => $logs,
            'stats' => $stats,
            'search' => $search,
            'period' => $period,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'limit' => $limit,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $period = $request->string('period')->toString();
        $dateFrom = $request->string('date_from')->toString();
        $dateTo = $request->string('date_to')->toString();
        $limitValue = $request->string('limit')->toString();
        $limit = $limitValue === 'all' ? null : ((in_array((int) $limitValue, [10, 20, 50, 100], true) ? (int) $limitValue : 20));

        $logs = $this->buildQuery($search, $period, $dateFrom, $dateTo, $limit)->get();

        $fileName = 'email-log-expired-' . now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'Email Log ID',
            'Domain',
            'Email',
            'Tanggal',
            'Expired',
            'Selisih',
            'Status',
        ], $logs->map(function (EmailLogExpired $log): array {
            return [
                (string) $log->email_log_id,
                $log->domain,
                $log->email,
                optional($log->tanggal)->format('Y-m-d H:i:s') ?? '-',
                optional($log->tgl_exp)->format('Y-m-d') ?? '-',
                (string) $log->selisih,
                $log->status ?? '-',
            ];
        })->all());
    }

    private function buildQuery(
        string $search,
        string $period,
        string $dateFrom,
        string $dateTo,
        ?int $limit
    ) {
        $query = EmailLogExpired::query()
            ->with(['dnsServer:domain,status,users_id'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('domain', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            });

        if ($period === 'today') {
            $query->whereDate('tanggal', today());
        } elseif ($period === '7_days') {
            $query->whereDate('tanggal', '>=', today()->subDays(7))
                ->whereDate('tanggal', '<=', today()->subDay());
        } elseif ($period === 'custom') {
            $query->when($dateFrom !== '', fn($query) => $query->whereDate('tanggal', '>=', Carbon::parse($dateFrom)));
            $query->when($dateTo !== '', fn($query) => $query->whereDate('tanggal', '<=', Carbon::parse($dateTo)));
        }

        $query->orderByDesc('email_log_id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query;
    }
}
