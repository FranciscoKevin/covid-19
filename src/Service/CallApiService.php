<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CallApiService
{
    public function __construct(private HttpClientInterface $client, private CacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
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
        $departmentByDate = $this->cache->get("details_department_".$date, function(ItemInterface $item) use($date){
            $item->expiresAfter(3600);
            return $this->getApi("departements-by-date/" . $date);
        });

        return $departmentByDate;
    }
}