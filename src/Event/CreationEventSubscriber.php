<?php

namespace App\Event;

use App\Entity\Administrator;
use App\Entity\Etablissement;
use App\Entity\Manager;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;


class CreationEventSubscriber implements EventSubscriberInterface
{
    private $passwordHasher;
    private $security;

    public function __construct(UserPasswordHasherInterface $passwordHasher,Security $security)
    {
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }


    public static function getSubscribedEvents()
    {
        return[
            BeforeEntityPersistedEvent::class => ['setEntity'],
            BeforeEntityUpdatedEvent::class=> ['updateEntity'],
        ];
    }

    public function setEntity(BeforeEntityPersistedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();
        $administrator = $this->security->getUser()->getAdministrator();

        //get the role of the current connected user
        $roleToken = $this->security->getUser()->getRoles();

        if($entityInstance instanceof User and in_array('ROLE_ADMIN',$roleToken)){

            //attribute the manager role and creation date
            $entityInstance->setRoles(['ROLE_MANAGER']);
            $entityInstance->setCreationDate(New \DateTime('now'));

            if (preg_match('^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',$entityInstance->getPassword())){
                //call a hash password function to transform and save in bdd crypted password if password is secure
                $hashedPassword = $this->hashPassword($entityInstance,$entityInstance->getPassword());
                $entityInstance->setPassword($hashedPassword);
            }

            //persist in the $manager table the role
            $manager = new Manager();
            //add the user id of the creator to Manager object

            $manager->setAdmin($administrator);
            $entityInstance->setManager($manager);


        }elseif($entityInstance instanceof Etablissement){
            $entityInstance->setCreationDate(New \DateTime('now'));
            $entityInstance->setAdmin($administrator);
        } else{
            throw new \Exception('not authorized to create user with role manager');
        }
    }

    public function updateEntity(BeforeEntityUpdatedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();
        $entityInstance->setCreationDate(New \DateTime('now'));
    }

    private function hashPassword($entityInstance,$stringToHash):string
    {
        return $this->passwordHasher->hashPassword($entityInstance,$stringToHash);

    }
}