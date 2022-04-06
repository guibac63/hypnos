<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminMakerController extends AbstractController
{
    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/makeradmin', name: 'app_admin_maker')]
    public function index(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
//        $ad = new User();
//        $ad->setFirstname('Ric');
//        $ad->setLastname('Lio');
//        $ad->setCreationDate(new \DateTime('now'));
//        $ad->setRoles(['ROLE_ADMIN']);

        $email = (new Email())
            ->from('guibacsoluce@gmail.com')
            ->to('guibac63@hotmail.fr')
            ->subject('test')
            ->text('salut test');
        $mailer->send($email);


        //$ad->setPassword($hashedPassword);

       // $admin = new Administrator();

        //$ad->addAdministrator($admin);

        //$entityManager->persist($ad);
        //$entityManager->flush();

        return new Response('<body>admin crée</body>');
    }
}
