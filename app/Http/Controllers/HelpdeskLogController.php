<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Http\Requests\HelpdeskLogStoreRequest;
use App\Http\Requests\HelpdeskLogUpdateRequest;
use App\Models\HelpdeskLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HelpdeskLogController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $query = HelpdeskLog::query()
            ->select(['helpdesk_log_id', 'domain', 'pelapor_nama', 'pelapor_phone', 'jenis_layanan', 'kanal', 'deskripsi', 'status', 'users_id', 'created_at'])
            ->with('user:id,name');

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('domain', 'like', "%{$search}%")
                    ->orWhere('pelapor_nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        $logs = $query->orderByDesc('created_at')->limit($limit)->get();

        $stats = [
            'total' => HelpdeskLog::query()->count(),
            'proses' => HelpdeskLog::query()->where('status', HelpdeskLog::STATUS_DIPROSES)->count(),
            'selesai' => HelpdeskLog::query()->where('status', HelpdeskLog::STATUS_SELESAI)->count(),
        ];

        return view('helpdesk-log.index', [
            'logs' => $logs,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'limit' => $limit,
        ]);
    }

    public function create(): View
    {
        return view('helpdesk-log.create');
    }

    public function store(HelpdeskLogStoreRequest $request): RedirectResponse
    {
        HelpdeskLog::query()->create([
            ...$request->validated(),
            'users_id' => auth()->id(),
        ]);

        return redirect()->route('helpdesk-log.index')->with('status', 'Laporan berhasil dicatat.');
    }

    public function edit(int $id): View
    {
        $log = HelpdeskLog::query()
            ->with('user:id,name')
            ->findOrFail($id);

        return view('helpdesk-log.edit', ['log' => $log]);
    }

    public function update(HelpdeskLogUpdateRequest $request, int $id): RedirectResponse
    {
        $log = HelpdeskLog::query()->findOrFail($id);
        $log->update($request->validated());

        return redirect()->route('helpdesk-log.index')->with('status', 'Status laporan diperbarui.');
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $query = HelpdeskLog::query()
            ->with('user:id,name')
            ->orderByDesc('created_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('domain', 'like', "%{$search}%")
                    ->orWhere('pelapor_nama', 'like', "%{$search}%")
                    ->orWhere('pelapor_email', 'like', "%{$search}%")
                    ->orWhere('isi_laporan', 'like', "%{$search}%");
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        $logs = $query->get();

        $fileName = 'helpdesk-log-'.now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'ID',
            'Tanggal',
            'Domain',
            'Pelapor',
            'Kontak',
            'Email',
            'Jenis Layanan',
            'Kanal',
            'Deskripsi',
            'Agent',
            'Status',
            'Catatan Tambahan',
        ], $logs->map(function (HelpdeskLog $log): array {
            return [
                (string) $log->helpdesk_log_id,
                $log->created_at?->format('Y-m-d H:i:s') ?? '-',
                $log->domain ?? '-',
                $log->pelapor_nama,
                $log->pelapor_phone,
                $log->pelapor_email ?? '-',
                $log->jenis_layanan,
                $log->kanal,
                $log->deskripsi,
                $log->user?->name ?? '-',
                $log->status,
                $log->catatan_tambahan ?? '-',
            ];
        })->all());
    }
}
