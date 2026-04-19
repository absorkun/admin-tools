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
        $dateFrom = $request->string('date_from')->toString();
        $dateTo = $request->string('date_to')->toString();
        if ($dateTo === '') {
            $dateTo = now()->toDateString();
        }
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $query = HelpdeskLog::query()
            ->select(['helpdesk_log_id', 'domain', 'pelapor_nama', 'pelapor_phone', 'jenis_layanan', 'kanal', 'deskripsi', 'status', 'users_id', 'created_at'])
            ->with('user:id,name')
            ->with('domainRecord:name,zone');

        if ($search !== '') {
            $query->where('domain', 'like', "%{$search}%");
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        $query->whereDate('created_at', '<=', $dateTo);

        $logs = $query->orderByDesc('created_at')->limit($limit)->get();

        return view('helpdesk-log.index', [
            'logs' => $logs,
            'search' => $search,
            'status' => $status,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'limit' => $limit,
        ]);
    }

    public function create(): View
    {
        return view('helpdesk-log.create');
    }

    public function store(HelpdeskLogStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($data['jenis_layanan'] === 'Lainnya' && $request->filled('jenis_layanan_lainnya')) {
            $data['jenis_layanan'] = $request->string('jenis_layanan_lainnya')->toString();
        }
        if ($data['kanal'] === 'Lainnya' && $request->filled('kanal_lainnya')) {
            $data['kanal'] = $request->string('kanal_lainnya')->toString();
        }

        HelpdeskLog::query()->create([
            ...$data,
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
        $data = $request->validated();
        if ($data['jenis_layanan'] === 'Lainnya' && $request->filled('jenis_layanan_lainnya')) {
            $data['jenis_layanan'] = $request->string('jenis_layanan_lainnya')->toString();
        }
        if ($data['kanal'] === 'Lainnya' && $request->filled('kanal_lainnya')) {
            $data['kanal'] = $request->string('kanal_lainnya')->toString();
        }
        $log->update($data);

        return redirect()->route('helpdesk-log.index')->with('status', 'Status laporan diperbarui.');
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $dateFrom = $request->string('date_from')->toString();
        $dateTo = $request->string('date_to')->toString();
        if ($dateTo === '') {
            $dateTo = now()->toDateString();
        }

        $query = HelpdeskLog::query()
            ->with('user:id,name')
            ->orderByDesc('created_at');

        if ($search !== '') {
            $query->where('domain', 'like', "%{$search}%");
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        $query->whereDate('created_at', '<=', $dateTo);

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
