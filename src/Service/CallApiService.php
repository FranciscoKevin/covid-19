<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    public function __construct(private HttpClientInterface $client)
    {
        $this->client = $client;
    }

    private function getApi(string $string) 
    {
        $response = $this->client->request(
            "GET",
            "https://coronavirusapifr.herokuapp.com/data/live/" . $string
        );
        return $response->toArray();
    }

    public function getFranceData(): array
    {
        return $this->getApi("france");
    }

    public function getAllDepartments(): array
    {
        return $this->getApi("departements");
    }

    public function getDepartment($department): array
    {
        return $this->getApi("departement/" . $department);
    }
}