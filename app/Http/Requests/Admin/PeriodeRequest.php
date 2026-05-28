<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PeriodeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2020', 'max:2099'],
            'status' => ['required', 'in:DRAFT,VOTING,DONE'],
            'theme_config' => ['nullable', 'string'],
            'reg_start_at' => ['required', 'date'],
            'reg_end_at' => ['required', 'date', 'after:reg_start_at'],
            'vote_start_at' => ['required', 'date', 'after_or_equal:reg_end_at'],
            'vote_end_at' => ['required', 'date', 'after:vote_start_at'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Periode',
            'year' => 'Tahun',
            'status' => 'Status',
            'reg_start_at' => 'Tanggal Mulai Registrasi',
            'reg_end_at' => 'Tanggal Selesai Registrasi',
            'vote_start_at' => 'Tanggal Mulai Voting',
            'vote_end_at' => 'Tanggal Selesai Voting',
        ];
    }
}
