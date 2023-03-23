<?php

namespace App\Http\Resources\Manager\Booking;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'date' => $this->date,
            'is_active' => $this->is_active,
            'teacher_id' => $this->teacher_id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
        ];
    }
}
