<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SectionCollectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(fn($resource) => SectionResource::make($resource)),
        ];
    }
}
