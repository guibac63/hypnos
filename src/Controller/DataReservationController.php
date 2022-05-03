<?php

namespace App\Controller;

use App\Entity\Suite;
use App\Repository\EtablissementRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->json(['data'=>$dataSuites]);
    }

    #[Route('/reservationsuite/{id}', name: 'resa-suite-name')]
    public function dataSuiteReservation(int $id, ReservationRepository $reservationRepository):Response
    {
        //search for data of the selected establishment
        $data = $reservationRepository->findBy(['suite'=>$id,'cancelled'=>false]);

        $dataReservations = [];

        //if query return response and reservations for the selected suite, collect data
        if($data && $data[0]){
            foreach($data as $reservation){
                //add one day to correctly displaying interval of reservation in fullcalendar.js
                $endDate = $reservation->getEndingDate()->format('Y-m-d');

                $dataReservations[] = [
                    'id'=> $reservation->getId(),
                    'start'=>$reservation->getBeginningDate()->format('Y-m-d'),
                    'end'=>date('Y-m-d',strtotime($endDate . ' +1 day')),
                    'title'=>'réservé',
                ];
            }
        }

        return $this->json(['data'=>$dataReservations]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/verifReservation/{id}/{date1}/{date2}', name: 'resa-verif')]
    public function verifReservation (ReservationRepository $reservationRepository,int $id,int $date1,int $date2):Response
    {
        //conversion date passed in timestamp param to php valid dates
        $dateBegin = date("Y-m-d",($date1/1000));
        $dateBegin = new \DateTime($dateBegin);
        $dateEnd = date("Y-m-d",($date2/1000));
        $dateEnd = new \DateTime($dateEnd);

        $dataReservation = $reservationRepository->findBy(['suite'=> $id,'cancelled'=> false]);

        //verif 1 :if beginning date <= today
        $dateBegin <= new \DateTime('now')? $verifOne = false : $verifOne = true;

        //verif 2 : if ending date is in more than one year
        $dateEnd > new \DateTime(date('Y-m-d',strtotime(' +1 year'))) ? $verifTwo = false : $verifTwo = true;

        //verif 3 : if the purposed dates is in conflict with another reservation, set verif to false
        $verifThree = true;

        foreach ($dataReservation as $reservation){
            if ($dateBegin >= $reservation->getBeginningDate() && $dateBegin <=$reservation->getEndingDate()){
                $verifThree = false;
            }

            if ($dateEnd >= $reservation->getBeginningDate() && $dateEnd <= $reservation->getEndingDate()){
                $verifThree = false;
            }
            if($dateBegin < $reservation->getBeginningDate() && $dateEnd > $reservation->getEndingDate()){
                $verifThree = false;
            }
        }

        //verif4 : if beginning date is > ending date
        $dateBegin > $dateEnd ? $verifFour = false : $verifFour = true;

        $verifAll=($verifOne && $verifTwo && $verifThree && $verifFour);

        return $this->json(['data'=>
            [
                'verif1'=>$verifOne,
                'verif2'=>$verifTwo,
                'verif3'=>$verifThree,
                'verif4'=>$verifFour,
                'verifAll'=>$verifAll
            ]
        ]);
    }

    #[Route('/annulReservation', name: 'resa-cancel')]
    public function cancelReservation (Request $request,ReservationRepository $reservationRepository):Response
    {
        //get the selected reservation id by the request data sending onclick button cancel
        $data = $request->request->get('reservation');

        if($data){

            //find the reservation linked to the ajax request
            $resaToCancel = $reservationRepository->findOneBy(['id'=>$data]);
            //change status to cancelled
            $resaToCancel->setCancelled(true);
            //update the database
            $reservationRepository->add($resaToCancel);

            return $this->json(['data'=>$data]);
        }else{
            throw new \Exception('Impossible to cancel an empty value ');
        }
    }

}