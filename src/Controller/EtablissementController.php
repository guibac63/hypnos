<?php

namespace App\Controller;


use App\Repository\EtablissementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'etablissement')]
    public function index( EtablissementRepository $etb, PaginatorInterface $paginator, Request $request):Response
    {
        $etbData = $etb->findAll();

        $etbPaginated = $paginator->paginate(
          $etbData,
          $request->query->getInt('page',1),
          3
        );

        return $this->render('etablissement.html.twig',['etablissements'=>$etbPaginated]);
    }

}