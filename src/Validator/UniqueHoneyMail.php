<?php

namespace App\Validator;
use Symfony\Component\Validator\Constraint;


class UniqueHoneyMail extends Constraint
{
    public $message = "There is already an account with this email";

    public function validatedBy()
    {
        return UniqueHoneyMailValidator::class;
    }
}