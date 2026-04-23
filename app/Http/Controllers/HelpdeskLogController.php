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

    public function importCsv(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle);
        $header = array_map('trim', $header);

        $expectedColumns = ['Tanggal', 'Domain', 'Pelapor', 'Kontak', 'Email', 'Jenis Layanan', 'Kanal', 'Deskripsi', 'Status', 'Catatan Tambahan'];
        $missing = array_diff($expectedColumns, $header);

        if (! empty($missing)) {
            fclose($handle);

            return back()->withErrors(['csv_file' => 'Kolom tidak sesuai. Kolom yang dibutuhkan: '.implode(', ', $expectedColumns)]);
        }

        $indexed = array_flip($header);
        $imported = 0;
        $errors = [];
        $row = 2;

        while (($line = fgetcsv($handle)) !== false) {
            $domain = trim($line[$indexed['Domain']] ?? '');
            $status = trim($line[$indexed['Status']] ?? '');
            $jenis = trim($line[$indexed['Jenis Layanan']] ?? '');
            $kanal = trim($line[$indexed['Kanal']] ?? '');
            $phone = trim($line[$indexed['Kontak']] ?? '-');
            $tanggal = trim($line[$indexed['Tanggal']] ?? '') ?: now()->toDateTimeString();

            if ($domain === '') {
                $errors[] = "Baris {$row}: kolom Domain kosong.";
                $row++;

                continue;
            }

            if (! in_array($status, HelpdeskLog::STATUSES, true)) {
                $errors[] = "Baris {$row}: status '{$status}' tidak valid.";
                $row++;

                continue;
            }

            HelpdeskLog::withoutTimestamps(function () use ($domain, $phone, $tanggal, $indexed, $line, $jenis, $kanal, $status): void {
                HelpdeskLog::query()->updateOrCreate(
                    ['domain' => $domain, 'pelapor_phone' => $phone, 'created_at' => $tanggal],
                    [
                        'pelapor_nama' => trim($line[$indexed['Pelapor']] ?? '-'),
                        'pelapor_phone' => $phone,
                        'pelapor_email' => trim($line[$indexed['Email']] ?? '') ?: null,
                        'jenis_layanan' => $jenis !== '' ? $jenis : 'Informasi',
                        'kanal' => $kanal !== '' ? $kanal : 'Lainnya',
                        'deskripsi' => trim($line[$indexed['Deskripsi']] ?? '-'),
                        'status' => $status,
                        'catatan_tambahan' => trim($line[$indexed['Catatan Tambahan']] ?? '') ?: null,
                        'users_id' => auth()->id(),
                        'created_at' => $tanggal,
                    ]
                );
            });

            $imported++;
            $row++;
        }

        fclose($handle);

        $message = "{$imported} baris berhasil diimport.";
        if (! empty($errors)) {
            $message .= ' Gagal: '.implode(' ', $errors);
        }

        return redirect()->route('helpdesk-log.index')->with('status', $message);
    }
}
