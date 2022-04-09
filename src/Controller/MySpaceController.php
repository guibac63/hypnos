<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MySpaceController extends AbstractController
{
    #[Route('/monespace', name: 'my_space')]
    public function index () :Response
    {
        return $this->render('mon-espace.html.twig',[]);
    }
}