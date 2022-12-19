<?php

namespace App\Http\Integrations\Scolarite\Requests\Section;

use App\Data\Section;
use App\Http\Integrations\Scolarite\GetScolariteRequest;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonResponse;

class GetSectionsRequest extends GetScolariteRequest
{
    public function defineEndpoint(): string
    {
        return '/api/sections';
    }

    protected function castToDto(SaloonResponse $response): Collection
    {
        return Section::fromSaloonResponseCollection($response);
    }
}
