<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuiteReservationController extends AbstractController
{
    #[Route('/reservation/{idSuite}', name: 'suite-reservation')]
    public function reservation(Request $request,int $idSuite = 0):Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        }

        return $this->render('suitereservation.html.twig',[
            'reservationForm'=> $form->createView()
        ]);
    }

}