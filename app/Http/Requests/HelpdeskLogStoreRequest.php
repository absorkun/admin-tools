<?php

namespace App\Http\Requests;

use App\Models\HelpdeskLog;
use Illuminate\Foundation\Http\FormRequest;

class HelpdeskLogStoreRequest extends FormRequest
{
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
            'domain' => ['required', 'string', 'max:255', 'exists:domains,name'],
            'pelapor_nama' => ['required', 'string', 'max:255'],
            'pelapor_email' => ['nullable', 'string', 'email', 'max:255'],
            'pelapor_phone' => ['required', 'string', 'max:50'],
            'jenis_layanan' => ['required', 'string', 'in:'.implode(',', HelpdeskLog::JENIS_LAYANAN)],
            'kanal' => ['required', 'string', 'in:'.implode(',', HelpdeskLog::KANAL)],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', 'string', 'in:'.implode(',', HelpdeskLog::STATUSES)],
            'catatan_tambahan' => ['nullable', 'string'],
            'jenis_layanan_lainnya' => ['nullable', 'string', 'max:255'],
            'kanal_lainnya' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'domain' => 'nama domain',
            'pelapor_nama' => 'nama pelapor',
            'pelapor_email' => 'email pelapor',
            'pelapor_phone' => 'nomor kontak',
            'jenis_layanan' => 'jenis layanan',
            'kanal' => 'kanal',
            'deskripsi' => 'pertanyaan',
            'status' => 'status',
            'catatan_tambahan' => 'jawaban',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max' => ':Attribute maksimal :max karakter.',
            'email' => ':Attribute harus berformat email yang valid.',
            'in' => ':Attribute yang dipilih tidak valid.',
            'exists' => ':Attribute tidak ditemukan dalam sistem.',
        ];
    }
}
