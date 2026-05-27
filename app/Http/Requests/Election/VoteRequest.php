<?php

namespace App\Http\Requests\Election;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'votes' => ['required', 'array', 'min:1'],
            'votes.*.category_id' => ['required', 'string', 'uuid', 'exists:election_categories,id'],
            'votes.*.candidate_id' => ['required', 'string', 'uuid', 'exists:candidates,id'],
        ];
    }
}
