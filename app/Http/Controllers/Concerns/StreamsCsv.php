<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait StreamsCsv
{
    /**
     * @param  array<int, string>  $headers
     * @param  iterable<array<int, string|int|float|null>>  $rows
     */
    protected function streamCsvDownload(string $filename, array $headers, iterable $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, Str::finish($filename, '.csv'), [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
