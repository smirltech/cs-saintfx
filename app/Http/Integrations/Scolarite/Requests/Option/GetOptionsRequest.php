<?php

namespace App\Http\Integrations\Scolarite\Requests\Option;

use App\Data\Option;
use App\Http\Integrations\Scolarite\GetScolariteRequest;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonResponse;

class GetOptionsRequest extends GetScolariteRequest
{
    public function defineEndpoint(): string
    {
        return '/api/options';
    }

    protected function castToDto(SaloonResponse $response): Collection
    {
        return Option::fromSaloonResponseCollection($response);
    }
}
