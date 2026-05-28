<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FakultasRequest extends FormRequest
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
        $fakultasId = $this->route('fakulta')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('faculties', 'code')->ignore($fakultasId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'dean_name' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'code' => 'Kode Fakultas',
            'name' => 'Nama Fakultas',
            'dean_name' => 'Nama Dekan',
            'is_active' => 'Status Aktif',
        ];
    }
}
