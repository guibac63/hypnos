<?php

namespace App\Controller;


use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'etablissement')]
    public function index( EtablissementRepository $etb):Response
    {
        $etbData = $etb->findAll();


        return $this->render('etablissement.html.twig',['etablissements'=>$etbData]);
    }

}