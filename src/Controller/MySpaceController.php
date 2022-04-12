<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MySpaceController extends AbstractController
{
    #[Route('/monespace', name: 'my_space')]
    public function index (Security $security,Request $request) :Response
    {

        //get the connected user : only subscribers can access to this route
        $user = $security->getUser();

        //get the reservations of the connected subscriber
        $userReservations = $user->getClient()->getReservations();


        $userInfos = [];

        foreach ($userReservations as $reservation){

            $beginning = $reservation->getBeginningDate()->format("Y-m-d");;

            //rule : can't cancel if reservation is less than three days in the future
            new \DateTime('now') <= new \DateTime(date('Y-m-d',strtotime($beginning. ' -3 days')))? $cancelable = true: $cancelable = false;

            $userInfos[] = ["reservations"=>$reservation,"cancelable"=>$cancelable];

        }


        return $this->render('mon-espace.html.twig',["userInfos"=>$userInfos,"user"=>$user]);
    }
}