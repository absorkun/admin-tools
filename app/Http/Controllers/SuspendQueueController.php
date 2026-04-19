<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $query = Domain::query()
            ->select(['id', 'name', 'zone', 'registrant_id', 'status', 'expired_date', 'expires_at'])
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<', today())
            ->where('status', '!=', 'suspend')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy('expired_date')
            ->orderBy('name');

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

        $domains = Domain::query()
            ->select(['id', 'name', 'zone', 'registrant_id', 'status', 'expired_date', 'expires_at'])
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<', today())
            ->where('status', '!=', 'suspend')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy('expired_date')
            ->orderBy('name')
            ->get();

        $fileName = 'suspend-queue-'.now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'Domain',
            'Zone',
            'Status',
            'Expired',
        ], $domains->map(function (Domain $domain): array {
            return [
                $domain->name,
                $domain->zone,
                $domain->status ?? 'ready suspend',
                optional($domain->expired_date)->format('Y-m-d') ?? '-',
            ];
        })->all());
    }

    public function suspend(Request $request, int $id): RedirectResponse
    {
        $domainModel = Domain::query()
            ->where('status', '!=', 'suspend')
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<', today())
            ->findOrFail($id);

        $domainModel->update([
            'status' => 'suspend',
        ]);

        Log::info('domain suspended from suspend queue', [
            'domain' => $domainModel->name,
        ]);

        return redirect()
            ->route('suspend-queue.index')
            ->with('status', "Domain {$domainModel->name} jadi suspend.");
    }
}
