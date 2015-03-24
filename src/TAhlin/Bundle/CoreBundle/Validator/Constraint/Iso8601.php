<?php

namespace TAhlin\Bundle\CoreBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class Iso8601 extends Constraint
{
    public $message = 'Date is not in ISO8601 format.';
}