<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\Domain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DomainController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $zone = $request->string('zone')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $domains = $this->baseQuery($search, $status, $zone)
            ->orderBy('name')
            ->limit($limit)
            ->get();

        return view('domain.index', [
            'domains' => $domains,
            'search' => $search,
            'status' => $status,
            'zone' => $zone,
            'limit' => $limit,
        ]);
    }

    public function show(int $id): View
    {
        $domain = Domain::query()
            ->with(['registrant:id,name,email'])
            ->findOrFail($id);

        return view('domain.show', [
            'domain' => $domain,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $zone = $request->string('zone')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $domains = $this->baseQuery($search, $status, $zone)->orderBy('name')->get();

        $fileName = 'domains-'.now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'Domain',
            'Zone',
            'Instansi',
            'Status',
            'Registered',
            'Expires',
            'Phone',
        ], $domains->map(function (Domain $domain): array {
            return [
                $domain->name,
                $domain->zone,
                $domain->nama_instansi ?? '-',
                $domain->status ?? '-',
                optional($domain->registered_at)->format('Y-m-d') ?? '-',
                optional($domain->expires_at)->format('Y-m-d') ?? '-',
                $domain->phone ?? '-',
            ];
        })->all());
    }

    public function search(Request $request): JsonResponse
    {
        $q = $request->string('q')->toString();

        $domains = Domain::query()
            ->select(['name', 'zone', 'status'])
            ->when($q !== '', function ($query) use ($q): void {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->limit(15)
            ->get();

        return response()->json($domains);
    }

    private function baseQuery(string $search, string $status = '', string $zone = '')
    {
        return Domain::query()
            ->select([
                'id',
                'name',
                'zone',
                'registered_at',
                'expires_at',
                'expired_date',
                'status',
                'registrant_id',
                'domain_name_server',
                'nama_instansi',
                'phone',
            ])
            ->with(['registrant:id,name,email'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($status !== '', function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->when($zone !== '', function ($query) use ($zone): void {
                $query->where('zone', $zone);
            });
    }
}
