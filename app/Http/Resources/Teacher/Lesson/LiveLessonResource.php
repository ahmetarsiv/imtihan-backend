<?php

namespace App\Http\Resources\Teacher\Lesson;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LiveLessonResource extends JsonResource
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
            'name' => $this->name,
            'date' => $this->date,
            'url' => $this->url,
            'class_id' => $this->class_id,
            'question_category_id' => $this->question_category_id,
            'company_id' => $this->company_id,
        ];
    }
}
