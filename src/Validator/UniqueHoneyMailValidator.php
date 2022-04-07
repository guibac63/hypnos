<?php

namespace App\Validator ;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueHoneyMailValidator extends ConstraintValidator
{
    private UserRepository $userRequest;

    /**
     * @param UserRepository $userRequest
     */
    public function __construct(UserRepository $userRequest)
    {
        $this->userRequest = $userRequest;
    }


    public function validate($value, Constraint $constraint)
    {
        // TODO: Implement validate() method.
        if(null === $value || '' === $value){
            return;
        }

        //try to find if a user had an account with the email typed in the input
        $requestUser = $this->userRequest->findBy(['email'=> $value]);

        if($requestUser){
          $this->context->buildViolation($constraint->message)
            ->addViolation();
        };


    }

}