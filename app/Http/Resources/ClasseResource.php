<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClasseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'grade' => $this->grade,
            'filierable' => $this->filierable,
            'filierable_type' => $this->filierable_type,
            'code' => $this->code,
        ];
    }
}
