<?php

namespace App\Http\Resources\Teacher\Exam;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ReportResource extends JsonResource
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
            'user' => $this->user,
            'total_question' => $this->total_question,
            'correct' => $this->correct_answer,
            'in_correct' => $this->in_correct,
            'blank' => $this->blank,
            'point' => $this->point,
            'categories' => $this->category,
            'created_at' => $this->created_at,
        ];
    }
}
