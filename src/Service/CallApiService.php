<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    public function __construct(private HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getFranceData(): array
    {
        $response = $this->client->request(
            "GET",
            "https://coronavirusapifr.herokuapp.com/data/live/france"
        );
        return $response->toArray();
    }
}