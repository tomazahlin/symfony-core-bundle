<?php

namespace Ahlin\Bundle\CoreBundle\Validator\Constraint;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class Iso8601Validator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof DateTime) {
            $value = $value->format(DateTime::ISO8601);
        }
        if (!(preg_match('/^(\d{4})-(\d{2})-(\d{2})(T|\s)(\d{2}):(\d{2}):(\d{2})(Z|(\+|-|\s)\d{2}(:?\d{2})?)$/', $value) > 0)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
