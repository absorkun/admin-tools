<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\DnsServer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DnsServerController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $query = DnsServer::query()
            ->select([
                'domain',
                'domains_id',
                'users_id',
                'name_srv',
                'status',
                'dnssec',
                'tgl_reg',
                'tgl_exp',
                'tgl_upd',
                'dns_a',
                'website',
                'tgl_exp_domains',
                'tgl_email',
                'jumlah_notif',
            ])
            ->with(['user:id,name,email'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('domain', 'like', "%{$search}%")
                        ->orWhere('name_srv', 'like', "%{$search}%")
                        ->orWhere('dns_a', 'like', "%{$search}%")
                        ->orWhere('website', 'like', "%{$search}%");
                });
            })
            ->orderBy('domain');

        $domains = $query->limit($limit)->get();

        $stats = [
            'total' => DnsServer::query()->count(),
            'active' => DnsServer::query()->whereRaw('LOWER(COALESCE(status, "")) = ?', ['active'])->count(),
            'suspend' => DnsServer::query()->whereRaw('LOWER(COALESCE(status, "")) = ?', ['suspend'])->count(),
            'expired' => DnsServer::query()->whereNotNull('tgl_exp')->whereDate('tgl_exp', '<', today())->count(),
        ];

        return view('dns-server.index', [
            'domains' => $domains,
            'stats' => $stats,
            'search' => $search,
            'limit' => $limit,
        ]);
    }

    public function show(string $domain): View
    {
        $dnsServer = DnsServer::query()
            ->with(['user:id,name,email'])
            ->findOrFail($domain);

        return view('dns-server.show', [
            'dnsServer' => $dnsServer,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $query = $this->baseQuery($search);
        $domains = $query->orderBy('domain')->limit($limit)->get();

        $fileName = 'dns-server'.now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'Domain',
            'Owner',
            'Email',
            'Status',
            'DNS A',
            'Website',
            'Tgl Exp',
            'Tgl Email',
            'Jumlah Notif',
        ], $domains->map(function (DnsServer $domain): array {
            return [
                $domain->domain,
                $domain->user?->name ?? '-',
                $domain->user?->email ?? '-',
                $domain->status ?? '-',
                $domain->dns_a ?? '-',
                $domain->website ?? '-',
                optional($domain->tgl_exp)->format('Y-m-d') ?? '-',
                optional($domain->tgl_email)->format('Y-m-d') ?? '-',
                (string) ($domain->jumlah_notif ?? 0),
            ];
        })->all());
    }

    private function baseQuery(string $search)
    {
        return DnsServer::query()
            ->select([
                'domain',
                'domains_id',
                'users_id',
                'name_srv',
                'status',
                'dnssec',
                'tgl_reg',
                'tgl_exp',
                'tgl_upd',
                'dns_a',
                'website',
                'tgl_exp_domains',
                'tgl_email',
                'jumlah_notif',
            ])
            ->with(['user:id,name,email'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('domain', 'like', "%{$search}%")
                        ->orWhere('name_srv', 'like', "%{$search}%")
                        ->orWhere('dns_a', 'like', "%{$search}%")
                        ->orWhere('website', 'like', "%{$search}%");
                });
            });
    }
}
