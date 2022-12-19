<?php

namespace App\Http\Integrations\Scolarite\Requests\Eleve;

use App\Data\Eleve;
use App\Http\Integrations\Scolarite\Requests\Option\GetScolariteCollectionRequest;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonResponse;

class GetElevesRequest extends GetScolariteCollectionRequest
{
    public function defineEndpoint(): string
    {
        return '/api/eleves';
    }

    protected function castToDto(SaloonResponse $response): Collection
    {
        return Eleve::fromSaloonResponseCollection($response, false);
    }
}
