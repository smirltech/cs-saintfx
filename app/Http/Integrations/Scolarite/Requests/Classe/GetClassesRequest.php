<?php

namespace App\Http\Integrations\Scolarite\Requests\Classe;

use App\Data\Classe;
use App\Http\Integrations\Scolarite\GetScolariteRequest;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonResponse;

class GetClassesRequest extends GetScolariteRequest
{
    public function defineEndpoint(): string
    {
        return '/api/classes';
    }

    protected function castToDto(SaloonResponse $response): Collection
    {
        return Classe::fromSaloonResponseCollection($response);
    }
}
