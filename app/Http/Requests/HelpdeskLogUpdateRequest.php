<?php

namespace App\Http\Requests;

use App\Models\HelpdeskLog;
use Illuminate\Foundation\Http\FormRequest;

class HelpdeskLogUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'domain' => ['required', 'string', 'max:255', 'exists:dns_server,domain'],
            'pelapor_nama' => ['required', 'string', 'max:255'],
            'pelapor_email' => ['nullable', 'string', 'email', 'max:255'],
            'pelapor_phone' => ['required', 'string', 'max:50'],
            'jenis_layanan' => ['required', 'string', 'in:'.implode(',', HelpdeskLog::JENIS_LAYANAN)],
            'kanal' => ['required', 'string', 'in:'.implode(',', HelpdeskLog::KANAL)],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', 'string', 'in:Diproses,Selesai'],
            'catatan_tambahan' => ['nullable', 'string'],
        ];
    }
}
