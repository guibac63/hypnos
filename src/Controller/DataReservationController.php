<?php

namespace App\Controller;

use App\Entity\Suite;
use App\Repository\EtablissementRepository;
use App\Repository\ReservationRepository;
use App\Repository\SuiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataReservationController extends AbstractController
{
    #[Route('/datasuitename/{id}', name: 'data-suite-name')]
    public function datasuite(int $id, EtablissementRepository $etbRepository):Response
    {
        //search for data of the selected establishment
        $data = $etbRepository->findBy(['id'=>$id]);

        $dataSuites = [];
        //if query return response and establishment get suites, collect data
        if($data && $data[0]->getSuites()){
            foreach($data[0]->getSuites() as $suite){
                $dataSuites[] = [
                    'value'=>$suite->getId(),
                    'text'=>$suite->getTitle()
                    ];
            }
        }

        //dd($dataSuites);

        return $this->json(['data'=>$dataSuites]);
    }

    #[Route('/reservationsuite/{id}', name: 'resa-suite-name')]
    public function dataSuiteReservation(int $id, ReservationRepository $reservationRepository):Response
    {
        //search for data of the selected establishment
        $data = $reservationRepository->findBy(['suite'=>$id]);

        $dataReservations = [];


        //if query return response and reservations for the selected suite, collect data
        if($data && $data[0]){
            foreach($data as $reservation){
                //add one day to correctly displaying interval of reservation in fullcalendar.js
                $endDate = $reservation->getEndingDate()->format('Y-m-d');

                $dataReservations[] = [
                    'id'=> $reservation->getId(),
                    'start'=>$reservation->getBeginningDate()->format('Y-m-d'),
                    'end'=>date('Y-m-d',strtotime($endDate . ' +1 day'))
                ];
            }
        }

        return $this->json(['data'=>$dataReservations]);
    }

}