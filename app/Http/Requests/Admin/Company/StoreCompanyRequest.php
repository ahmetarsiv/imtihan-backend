<?php

namespace App\Http\Requests\Admin\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255',
            'is_active' => 'boolean',
            'tax_id' => 'required|integer',
            'email' => 'required|string|email|max:255',
            'web_url' => 'string|max:255',
            'phone' => 'required|string|max:255',
            'logo' => 'required|file',
            'country_id' => 'required|numeric|exists:countries,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'state_id' => 'required|numeric|exists:states,id',
            'address' => 'required|string|max:600',
            'zip_code' => 'required|string|max:255',
        ];
    }
}
