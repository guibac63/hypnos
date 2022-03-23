<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ManagerCreateVoter extends Voter
{
    public const EDIT = 'PAGE_EDIT';
    public const DELETE = 'PAGE_DELETE';
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT,self::DELETE])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $manager, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or
                //dd($this->canEdit($manager));
                return $this->canEdit($manager);
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW

               return $this->canDelete($manager);
                break;
        }
        //return false;
    }

    private function canEdit($manager):bool

    {
        //dd($manager->getRoles());
        return in_array('ROLE_MANAGER', $manager->getRoles());
    }

    private function canDelete($manager):bool

    {
        //dd($manager->getRoles());
        return in_array('ROLE_MANAGER', $manager->getRoles());
    }





}
