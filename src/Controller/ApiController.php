<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'api')]
    public function index(CallApiService $callApiService): Response
    {
        //dd($callApiService->getFranceData());
        return $this->render('api/index.html.twig', [
            'data' => $callApiService->getFranceData(),
        ]);
    }
}
