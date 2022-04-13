<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route("/contact",name:"contact")]
    public function index(MailerInterface $mailer, Request $request):Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //if the honeypot is empty, send message
            if(!$form->get("email")->getData()){
                $contactEmail = (new Email())
                    ->from($form->get("hpt200")->getData())
                    ->to("guibacsoluce@gmail.com")
                    ->subject($form->get("subject")->getData() ."-".$form->get("hpt200")->getData() )
                    ->text($form->get("message")->getData());

                $confirmationMail = (new Email())
                    ->from("guibacsoluce@gmail.com")
                    ->to($form->get("hpt200")->getData())
                    ->subject("Confirmation d'envoi")
                    ->text("Votre message a bien été envoyé à nos équipes. Nous le traiterons dans les plus brefs délais et 
                 reprendrons contact avec vous très prochainement");

                $mailer->send($contactEmail);
                $mailer->send($confirmationMail);

                $this->addFlash('success',"Votre message a bien été envoyé. Vous allez recevoir une confirmation d'envoi par email");
            }

        }

        return $this->render('contact.html.twig',[
            'contactForm'=> $form->createView()
        ]);
    }
}