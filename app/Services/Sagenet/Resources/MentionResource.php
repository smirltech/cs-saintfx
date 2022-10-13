<?php

declare(strict_types=1);

namespace App\Services\Sagenet\Resources;

use App\Services\Sagenet\SagenetService;
use Illuminate\Http\Client\Response;

class MentionResource
{
    public function __construct(private readonly SagenetService $service)
    {
    }

    public function show(string $matricule, string $promotion): Response
    {
        return $this->service->post(
            request: $this->service->buildRequestWithToken(),
            url: "/mentions/search?include=etudiant",
            payload: $this->buildShowPayload($matricule, $promotion)
        );
    }

    private function buildShowPayload(string $matricule, string $promotion)
    {
        return [
            "scopes" => [
                [
                    "name" => "matricule",
                    "parameters" => [
                        $matricule
                    ]
                ]
            ],
            "filters" => [
                [
                    "field" => "promotion",
                    "operator" => "=",
                    "value" => $promotion
                ]
            ]
        ];
    }

    public function list(string $matricule, array $promotions = []): Response
    {
        return $this->service->post(
            request: $this->service->buildRequestWithToken(),
            url: "/mentions/search",
            payload: $this->buildPayload($matricule, $promotions)
        );
    }

    private function buildPayload(string $matricule, array $promotions = []): array
    {
        return [
            "scopes" => [
                [
                    "name" => "matricule",
                    "parameters" => [
                        $matricule
                    ]
                ]
            ],
            "filters" => [
                [
                    "field" => "promotion",
                    "operator" => "in",
                    "value" => $promotions
                ]
            ]
        ];
    }

}
