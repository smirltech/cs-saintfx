<?php

namespace App\Services\Sagenet\Resources;

use App\Services\Sagenet\SagenetService;
use Illuminate\Http\Client\Response;

class EtudiantResource
{

    public function __construct(private readonly SagenetService $service)
    {
    }

    public function list(): Response
    {
        return $this->service->get(
            request: $this->service->buildRequestWithToken(),
            url: "/etudiants",
        );
    }

    public function show(string $identifier): Response
    {
        return $this->service->get(
            request: $this->service->buildRequestWithToken(),
            url: "/etudiants/{$identifier}/?include=mentions",
        );
    }

    /**
     * @param string $keyword The keyword to search for. The keyword can be matricule, nom, etc.
     * @return Response
     */
    public function search(string $keyword): Response
    {
        return $this->service->post(
            request: $this->service->buildRequestWithToken(),
            url: "/etudiants/search",
            payload: [
                "search" => [
                    "value" => $keyword
                ]
            ]
        );
    }
}
