<?php

namespace App\Http\Integrations\Scolarite\Requests\Inscription;

use App\Data\Inscription;
use App\Http\Integrations\Scolarite\ScolariteConnector;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class GetInscriptionsRequest extends SaloonRequest
{

    use HasJsonBody, CastsToDto;

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
    protected ?string $method = Saloon::POST;

    public function __construct(
        public ?int $anneeId = null,
        public ?int $eleveId = null,
        public ?int $classeId = null,
    )
    {
    }

    /**
     * The endpoint of the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/api/inscriptions/search?include=eleve,classe,annee';
    }

    public function defaultData(): array
    {
        return [
            'scopes' => [
                [
                    'name' => 'annee',
                    'parameters' => [
                        "{$this->anneeId}"
                    ]
                ],
                [
                    'name' => 'eleve',
                    'parameters' => [
                        "{$this->eleveId}"
                    ]
                ],
                [
                    'name' => 'classe',
                    'parameters' => [
                        "{$this->classeId}"
                    ]
                ]
            ]
        ];
    }

    protected function castToDto(SaloonResponse $response): Collection
    {
        return Inscription::fromSaloonResponseCollection($response, false);
    }
}
