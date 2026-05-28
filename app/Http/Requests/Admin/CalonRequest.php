<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CalonRequest extends FormRequest
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
            'category_id' => ['required', 'exists:election_categories,id'],
            'number' => ['required', 'integer', 'min:1'],
            'nama_ketua' => ['required', 'string', 'max:255'],
            'nama_wakil' => ['nullable', 'string', 'max:255'],
            'student_ketua_id' => ['nullable', 'exists:students,id'],
            'student_wakil_id' => ['nullable', 'exists:students,id'],
            'vision' => ['required', 'string'],
            'mission' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'Kategori Pemilihan',
            'number' => 'Nomor Urut',
            'nama_ketua' => 'Nama Ketua',
            'nama_wakil' => 'Nama Wakil',
            'vision' => 'Visi',
            'mission' => 'Misi',
            'photo' => 'Foto Paslon',
        ];
    }
}
