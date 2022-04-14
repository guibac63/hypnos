<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class cgv extends AbstractController
{
    #[Route('/cgv','cgv')]
    public function cgv()
    {
        return $this->render('cgv.html.twig');
    }
}