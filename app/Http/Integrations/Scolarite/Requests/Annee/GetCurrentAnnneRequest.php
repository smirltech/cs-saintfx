<?php

namespace App\Http\Integrations\Scolarite\Requests\Annee;

use App\Data\Annee;
use App\Http\Integrations\Scolarite\ScolariteConnector;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;

class GetCurrentAnnneRequest extends SaloonRequest
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

    /**
     * The endpoint of the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/api/annees/encours';
    }


    protected function castToDto(SaloonResponse $response): Annee
    {
        return Annee::fromSaloonResponse($response);
    }
}
