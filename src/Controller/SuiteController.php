<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\SuiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuiteController extends AbstractController
{
    #[Route('/etablissement/{idEtab}', name: 'suites')]
    public function index(int $idEtab,SuiteRepository $suiteData):Response
    {
        //get all the datas of the suites of the chosen establishment (clicked button)
        $suiteInfos = $suiteData->findBy([
            'etablissement'=>$idEtab
        ]);


        return $this->render('suite.html.twig',['suites'=>$suiteInfos,'etb'=>$idEtab]);
    }
}