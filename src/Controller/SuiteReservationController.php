<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SuiteReservationController extends AbstractController
{
    #[Route('/reservation/{idEtb}/{idSuite}', name: 'suite-reservation')]
    public function reservation(Request $request, Security $security,EntityManagerInterface $entityManager,int $idEtb = 0,int $idSuite = 0):Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //even if validation button not showed, add security to verify if the reservator is a subscriber and is mail
            //has been verified
            if(in_array("ROLE_SUBSCRIBER",$security->getUser()->getRoles()) && $security->getUser()->isVerified()){

                $reservation->setClient($security->getUser()->getClient());
                $reservation->setCreationDate(new \DateTime('now'));
                $entityManager->persist($reservation);
                $entityManager->flush();
                $this->addFlash('success', 'Votre réservation vient d\'être confirmée! Vous pouvez à tout moment consulter vos informations dans votre espace personnel' );

            }
        }

        return $this->render('suitereservation.html.twig',[
            'reservationForm'=> $form->createView()
        ]);
    }

}