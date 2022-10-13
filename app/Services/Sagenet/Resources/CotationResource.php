<?php

namespace App\Services\Sagenet\Resources;

use App\Services\Sagenet\SagenetService;
use Illuminate\Http\Client\Response;

class CotationResource
{
    public function __construct(private readonly SagenetService $service)
    {

    }

    public function list(string $matricule, string $promotion): Response
    {
        return $this->service->post(
            request: $this->service->buildRequestWithToken(),
            url: "/cotations/search?include=cours&limit=50",
            payload: $this->buildPayload($matricule, $promotion)

        );
    }

    private function buildPayload(string $matricule, string $promotion): array
    {
        return [
            "scopes" => [
                [
                    "name" => "matricule",
                    "parameters" => [
                        $matricule
                    ]
                ],
                [
                    "name" => "promotion",
                    "parameters" => [
                        $promotion
                    ]
                ]
            ]
        ];
    }


}
