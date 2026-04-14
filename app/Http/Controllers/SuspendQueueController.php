<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\DnsServer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SuspendQueueController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $query = DnsServer::query()
            ->select(['domain', 'users_id', 'status', 'tgl_exp', 'tgl_email', 'jumlah_notif'])
            ->whereNotNull('tgl_exp')
            ->whereDate('tgl_exp', '<', today())
            ->whereNotNull('tgl_email')
            ->whereDate('tgl_email', '<=', today()->subDays(14))
            ->where(function ($query): void {
                $query->whereNull('status')
                    ->orWhereRaw("LOWER(COALESCE(status, '')) <> 'suspend'");
            })
            ->whereHas('emailLogExpireds')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('domain', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy('tgl_exp')
            ->orderBy('domain');

        $domains = $query->limit($limit)->get();

        return view('suspend-queue.index', [
            'search' => $search,
            'limit' => $limit,
            'domains' => $domains,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $domains = DnsServer::query()
            ->select(['domain', 'users_id', 'status', 'tgl_exp', 'tgl_email', 'jumlah_notif'])
            ->whereNotNull('tgl_exp')
            ->whereDate('tgl_exp', '<', today())
            ->whereNotNull('tgl_email')
            ->whereDate('tgl_email', '<=', today()->subDays(14))
            ->where(function ($query): void {
                $query->whereNull('status')
                    ->orWhereRaw("LOWER(COALESCE(status, '')) <> 'suspend'");
            })
            ->whereHas('emailLogExpireds')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('domain', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy('tgl_exp')
            ->orderBy('domain')
            ->limit($limit)
            ->get();

        $fileName = 'suspend-queue' . now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'Domain',
            'Status',
            'Expired',
            'Email Sent',
            'Notif',
        ], $domains->map(function (DnsServer $domain): array {
            return [
                $domain->domain,
                $domain->status ?? 'ready suspend',
                optional($domain->tgl_exp)->format('Y-m-d') ?? '-',
                optional($domain->tgl_email)->format('Y-m-d') ?? '-',
                (string) ($domain->jumlah_notif ?? 0),
            ];
        })->all());
    }

    public function suspend(Request $request, string $domain): RedirectResponse
    {
        $domainModel = DnsServer::query()
            ->where('domain', $domain)
            ->whereNotNull('tgl_exp')
            ->whereDate('tgl_exp', '<', today())
            ->whereNotNull('tgl_email')
            ->whereDate('tgl_email', '<=', today()->subDays(14))
            ->firstOrFail();

        $domainModel->update([
            'status' => 'suspend',
        ]);

        Log::info('dns_server suspended from suspend queue', [
            'domain' => $domainModel->domain,
        ]);

        return redirect()
            ->route('suspend-queue.index')
            ->with('status', "Domain {$domainModel->domain} jadi suspend.");
    }
}
