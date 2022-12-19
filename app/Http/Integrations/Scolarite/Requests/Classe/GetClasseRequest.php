<?php

namespace App\Http\Integrations\Scolarite\Requests\Classe;

use App\Data\Classe;
use App\Http\Integrations\Scolarite\GetScolariteRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;

class GetClasseRequest extends GetScolariteRequest
{

    public function __construct(private int $id)
    {
    }

    public function defineEndpoint(): string
    {
        return "/api/classes/{$this->id}?include=inscriptions";
    }

    protected function castToDto(SaloonResponse $response): Classe
    {
        return Classe::fromSaloonResponse($response);
    }
}
