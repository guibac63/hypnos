<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(EtablissementRepository $etb):Response
    {
        //get the data from current etablissements
        $etbData = $etb->findAll();

        return $this->render('home.html.twig',['etablissements'=>$etbData]);
    }

}