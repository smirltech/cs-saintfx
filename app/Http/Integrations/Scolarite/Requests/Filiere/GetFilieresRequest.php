<?php

namespace App\Http\Integrations\Scolarite\Requests\Filiere;

use App\Data\Filiere;
use App\Http\Integrations\Scolarite\GetScolariteRequest;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonResponse;

class GetFilieresRequest extends GetScolariteRequest
{
    public function defineEndpoint(): string
    {
        return '/api/filieres';
    }

    protected function castToDto(SaloonResponse $response): Collection
    {
        return Filiere::fromSaloonResponseCollection($response);
    }
}
