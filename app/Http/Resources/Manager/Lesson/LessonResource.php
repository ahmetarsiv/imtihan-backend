<?php

namespace App\Http\Resources\Manager\Lesson;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LessonResource extends JsonResource
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
            'id' => $this->lesson_id,
            'name' => $this->lesson->name,
            'content' => $this->lesson->content,
            'category_id' => $this->lesson->category_id,
            'language_id' => $this->lesson->language_id,
        ];
    }
}
