<?php

namespace App\Http\Integrations\Scolarite\Requests\Filiere;

use App\Data\Filiere;
use App\Http\Integrations\Scolarite\ScolariteConnector;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;

class GetFiliereRequest extends SaloonRequest
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

    public function __construct(private readonly int $id)
    {
    }

    /**
     * The endpoint of the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return "/api/filieres/{$this->id}?include=classes";
    }

    protected function castToDto(SaloonResponse $response): Filiere
    {
        return Filiere::fromSaloonResponse($response);
    }
}
