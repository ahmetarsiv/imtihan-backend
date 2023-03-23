<?php

namespace App\Http\Resources\Admin\Company;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subdomain' => $this->subdomain,
            'is_active' => $this->is_active,
            'tax_id' => $this->tax_id,
            'email' => $this->email,
            'web_url' => $this->web_url,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'address' => $this->address,
            'zip_code' => $this->zip_code,
        ];
    }
}
