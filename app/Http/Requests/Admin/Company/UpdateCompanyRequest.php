<?php

namespace App\Http\Requests\Admin\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'string|max:255',
            'subdomain' => 'string|max:255',
            'is_active' => 'boolean',
            'tax_id' => 'integer',
            'email' => 'string|email|max:255',
            'web_url' => 'string|max:255',
            'phone' => 'string|max:255',
            'logo' => 'file',
            'country_id' => 'numeric|exists:countries,id',
            'city_id' => 'numeric|exists:cities,id',
            'state_id' => 'numeric|exists:states,id',
            'address' => 'string|max:600',
            'zip_code' => 'string|max:255',
        ];
    }
}
