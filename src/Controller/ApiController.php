<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'api')]
    public function getAllFrance(CallApiService $callApiService): Response
    {
        //dd($callApiService->getAllDepartments());
        return $this->render('api/france.html.twig', [
            'data' => $callApiService->getFranceData(),
        ]);
    }

    #[Route('/tous-les-departements', name: 'departments')]
    public function getAllDepartments(CallApiService $callApiService): Response
    {
        //dd($callApiService->getAllDepartments());
        return $this->render('api/all_departments.html.twig', [
            'departments' => $callApiService->getAllDepartments(),
        ]);
    }

    #[Route('/departement/{department}', name: 'department')]
    public function getByDepartment(string $department, CallApiService $callApiService): Response
    {
        //dd($callApiService->getDepartment($department));
        return $this->render('api/by_department.html.twig', [
            'department' => $callApiService->getDepartment($department),
        ]);
    }
}
