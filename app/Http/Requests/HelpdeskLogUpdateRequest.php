<?php

namespace App\Http\Requests;

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
            'status' => ['required', 'string', 'in:baru,proses,selesai'],
            'catatan_admin' => ['nullable', 'string'],
        ];
    }
}
