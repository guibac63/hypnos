<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Mentions extends AbstractController
{
    #[Route("/mentions","mention")]
    public function mention():Response
    {
        return $this->render('mentions.html.twig');
    }

}