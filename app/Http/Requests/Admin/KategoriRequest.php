<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KategoriRequest extends FormRequest
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
            'period_id' => ['required', 'exists:election_periods,id'],
            'scope_faculty_id' => ['nullable', 'exists:faculties,id'],
            'type' => ['required', 'in:PRESIDENT,DPM,FACULTY_GOVERNOR'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'vote_start_at' => ['nullable', 'date'],
            'vote_end_at' => ['nullable', 'date', 'after:vote_start_at'],
            'max_winners' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'period_id' => 'Periode',
            'scope_faculty_id' => 'Fakultas',
            'type' => 'Tipe Pemilihan',
            'title' => 'Judul',
            'description' => 'Deskripsi',
            'vote_start_at' => 'Tanggal Mulai Voting',
            'vote_end_at' => 'Tanggal Selesai Voting',
            'max_winners' => 'Maks. Pemenang',
        ];
    }
}
