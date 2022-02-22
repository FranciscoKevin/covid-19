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
            "https://coronavirusapifr.herokuapp.com/data/" . $string
        );
        return $response->toArray();
    }

    public function getFranceData(): array
    {
        return $this->getApi("live/france");
    }

    public function getAllDepartments(): array
    {
        return $this->getApi("live/departements");
    }

    public function getDepartment(string $department): array
    {
        return $this->getApi("live/departement/" . $department);
    }

    public function getAllDepartmentByDate(string $date): array
    {
        return $this->getApi("departements-by-date/" . $date);
    }
}