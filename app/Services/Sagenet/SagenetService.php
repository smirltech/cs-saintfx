<?php
declare(strict_types=1);

namespace App\Services\Sagenet;

use App\Services\Concerns\BuildBaseRequest;
use App\Services\Concerns\CanSendGetRequest;
use App\Services\Concerns\CanSendPostRequest;
use App\Services\Sagenet\Resources\CotationResource;
use App\Services\Sagenet\Resources\EtudiantResource;
use App\Services\Sagenet\Resources\MentionResource;

class SagenetService
{
    use BuildBaseRequest;
    use CanSendGetRequest;
    use CanSendPostRequest;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiToken
    )
    {
    }

    public function mention(): MentionResource
    {
        return new MentionResource(
            service: $this
        );
    }

    public function etudiant(): EtudiantResource
    {
        return new EtudiantResource(
            service: $this
        );
    }

    public function cotation(): CotationResource
    {
        return new CotationResource(
            service: $this
        );
    }

}
