<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\SuiteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuiteController extends AbstractController
{
    #[Route('/etablissement/{idEtab}', name: 'suites')]
    public function index(int $idEtab,SuiteRepository $suiteData,PaginatorInterface $paginator, Request $request):Response
    {
        //get all the datas of the suites of the chosen establishment (clicked button)
        $suiteInfos = $suiteData->findBy([
            'etablissement'=>$idEtab
        ]);

        //apply the pagination system with 3 items per page
        $suitePaginated = $paginator->paginate(
            $suiteInfos,
            $request->query->getInt('page',1),
            3
        );

        return $this->render('suite.html.twig',['suites'=>$suitePaginated,'etb'=>$idEtab]);
    }
}