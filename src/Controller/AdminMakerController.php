<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminMakerController extends AbstractController
{
    #[Route('/makeradmin', name: 'app_admin_maker')]
    public function index(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $ad = new User();
        $ad->setFirstname('Richard');
        $ad->setLastname('Lionheart');
        $ad->setEmail('RichLion@gmail.com');
        $ad->setCreationDate(new \DateTime('now'));
        $ad->setRoles(['ROLE_ADMIN']);

        $passwordText = 'YourNameIsAdmin@63';
        $hashedPassword = $passwordHasher->hashPassword($ad,$passwordText);

        $ad->setPassword($hashedPassword);

        $admin = new Administrator();

        $ad->addAdministrator($admin);

        $entityManager->persist($ad);
        $entityManager->flush();

        return new Response('<body>admin crée</body>');
    }
}
