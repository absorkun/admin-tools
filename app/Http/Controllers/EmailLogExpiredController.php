<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\EmailLogExpired;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmailLogExpiredController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $logs = $this->buildQuery($search, $limit)->get();

        return view('email-log-expired.index', [
            'logs' => $logs,
            'search' => $search,
            'limit' => $limit,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $logs = $this->buildQuery($search)->get();

        $fileName = 'email-log-expired-'.now()->format('Y-m-d-H-i-s');

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

    private function buildQuery(string $search, ?int $limit = null)
    {
        $query = EmailLogExpired::query()
            ->with(['domain:name,status,registrant_id'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('domain', 'like', "%{$search}%");
            })
            ->orderByDesc('email_log_id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query;
    }
}
