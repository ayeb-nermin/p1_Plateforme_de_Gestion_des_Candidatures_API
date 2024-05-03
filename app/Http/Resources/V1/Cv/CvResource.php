<?php

namespace App\Http\Resources\V1\Cv;

use Illuminate\Http\Resources\Json\JsonResource;

class CvResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,

            'created_at' => dateTimeFormat($this->created_at),
            'updated_at' => dateTimeFormat($this->updated_at),
        ];
    }
}
