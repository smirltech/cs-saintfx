<?php

namespace App\Http\Integrations\Scolarite\Requests\Eleve;

use App\Data\Eleve;
use App\Http\Integrations\Scolarite\ScolariteConnector;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;

class GetEleveRequest extends SaloonRequest
{
    use CastsToDto;

    /**
     * The connector class.
     *
     * @var string|null
     */
    protected ?string $connector = ScolariteConnector::class;

    /**
     * The HTTP verb the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;


    public function __construct(public int $id)
    {
    }


    /**
     * The endpoint of the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return "/api/eleves/{$this->id}";
    }

    protected function castToDto(SaloonResponse $response): Eleve
    {
        return Eleve::fromSaloonResponse($response);
    }
}
