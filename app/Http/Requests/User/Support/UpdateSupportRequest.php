<?php

namespace App\Http\Requests\User\Support;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'subject' => 'string',
            'message' => 'string',
            'is_active' => 'boolean',
            'user_id' => 'numeric|exists:users,id',
            'company_id' => 'numeric|exists:companies,id',
        ];
    }
}
