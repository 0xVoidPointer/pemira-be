<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InformasiRequest extends FormRequest
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
            'kata_sambutan' => ['nullable', 'string', 'max:5000'],
            'peraturan_pemira' => ['nullable', 'string', 'max:10000'],
            'pemaparan_singkat' => ['nullable', 'string', 'max:5000'],
            'hotline' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'kata_sambutan' => 'Kata Sambutan Ketua KPUR',
            'peraturan_pemira' => 'Peraturan Pemira',
            'pemaparan_singkat' => 'Pemaparan Singkat',
            'hotline' => 'Hotline / Kontak Pengaduan',
        ];
    }
}
