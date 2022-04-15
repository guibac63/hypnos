<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Cgv extends AbstractController
{
    #[Route('/cgv','cgv')]
    public function cgv():Response
    {
        return $this->render('cgv.html.twig');
    }
}