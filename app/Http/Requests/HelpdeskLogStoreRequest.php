<?php

namespace App\Http\Requests;

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
            'domain' => ['required', 'string', 'max:255', 'exists:dns_server,domain'],
            'pelapor_nama' => ['required', 'string', 'max:255'],
            'pelapor_email' => ['required', 'string', 'email', 'max:255'],
            'pelapor_phone' => ['nullable', 'string', 'max:50'],
            'sumber' => ['required', 'string', 'in:whatsapp,email,telepon,lainnya'],
            'isi_laporan' => ['required', 'string'],
        ];
    }
}
