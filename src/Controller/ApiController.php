<?php

namespace App\Controller;

use App\Service\CallApiService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ApiController extends AbstractController
{
    public function __construct(private CallApiService $callApiService)
    {
        $this->callApiService = $callApiService;
    }

    #[Route('/toute-la-france', name: 'france')]
    public function showAllFranceData(): Response
    {
        return $this->render('api/france.html.twig', [
            'data' => $this->callApiService->getFranceData(),
        ]);
    }

    #[Route('/france/tous-les-departements', name: 'departments')]
    public function showAllDepartments(): Response
    {
        return $this->render('api/all_departments.html.twig', [
            'departments' => $this->callApiService->getAllDepartments(),
        ]);
    }

    #[Route('/france/departement/{department}', name: 'department')]
    public function showByDepartment(string $department, ChartBuilderInterface $chartBuilder): Response
    {
        //Array for chartBuilder
        $label = [];
        $hospitalisation = [];
        $reanimation = [];

        // Seven days of the week
        for ($i=1; $i < 8; $i++) { 
            $date = New DateTime('- ' . $i .' day');
            $allData = $this->callApiService->getAllDepartmentByDate($date->format('d-m-Y'));

            foreach ($allData as $data) {
                if( $data['lib_dep'] === $department) {
                    $label[] = $data['date'];
                    $hospitalisation[] = $data['hosp'];
                    $reanimation[] = $data['rea'];
                    break;
                }
            }
        }

        // Create Graphic with data
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_reverse($label),
            'datasets' => [
                [
                    'label' => 'Nouvelles hospitalisations',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_reverse($hospitalisation),
                ],
                [
                    'label' => 'Nouvelles entrées en réanimation',
                    'borderColor' => 'rgb(46, 41, 78)',
                    'data' => array_reverse($reanimation),
                ],
            ],
        ]);

        $chart->setOptions([/* ... */]);

        return $this->render('api/by_department.html.twig', [
            'department' => $this->callApiService->getDepartment($department),
            'chart' => $chart,
        ]);
    }
}
