<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $dateFrom = $request->string('date_from')->toString() ?: now()->format('Y-m-d');
        $dateTo = $request->string('date_to')->toString() ?: now()->format('Y-m-d');
        $subjectType = $request->string('subject_type')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $query = Activity::query()
            ->with('causer')
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('properties', 'like', "%{$search}%");
            });
        }

        $query->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo);

        if ($subjectType !== '') {
            $query->where('subject_type', $subjectType);
        }

        $logs = $query->limit($limit)->get();

        $subjectTypes = Activity::query()->distinct()->pluck('subject_type')->filter()->values();

        return view('activity-log.index', [
            'logs' => $logs,
            'subjectTypes' => $subjectTypes,
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'subjectType' => $subjectType,
            'limit' => $limit,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $dateFrom = $request->string('date_from')->toString() ?: now()->format('Y-m-d');
        $dateTo = $request->string('date_to')->toString() ?: now()->format('Y-m-d');
        $subjectType = $request->string('subject_type')->toString();

        $query = Activity::query()
            ->with('causer')
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('properties', 'like', "%{$search}%");
            });
        }

        $query->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo);

        if ($subjectType !== '') {
            $query->where('subject_type', $subjectType);
        }

        $logs = $query->get();

        $fileName = 'activity-log-'.now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'ID',
            'Waktu',
            'User',
            'Event',
            'Subject Type',
            'Subject ID',
            'Perubahan',
        ], $logs->map(function (Activity $log): array {
            $changes = '';
            if ($log->attribute_changes && isset($log->attribute_changes['attributes'])) {
                $parts = [];
                foreach ($log->attribute_changes['attributes'] as $key => $value) {
                    $old = $log->attribute_changes['old'][$key] ?? null;
                    $parts[] = $old !== null
                        ? "{$key}: {$old} → {$value}"
                        : "{$key}: {$value}";
                }
                $changes = implode('; ', $parts);
            }

            return [
                (string) $log->id,
                $log->created_at?->format('Y-m-d H:i:s') ?? '-',
                $log->causer?->name ?? 'System',
                $log->description,
                class_basename($log->subject_type ?? '-'),
                (string) $log->subject_id,
                $changes,
            ];
        }));
    }
}
