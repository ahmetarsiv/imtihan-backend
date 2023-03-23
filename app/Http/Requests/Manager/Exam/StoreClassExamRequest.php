<?php

namespace App\Http\Requests\Manager\Exam;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassExamRequest extends FormRequest
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
            'company_id' => 'nullable',
            'class_id' => 'required|numeric',
            'is_active' => 'required|boolean',
            'categories' => 'required|array',
        ];
    }
}
