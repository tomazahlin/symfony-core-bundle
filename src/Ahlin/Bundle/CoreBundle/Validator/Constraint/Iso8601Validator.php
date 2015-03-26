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
        if (!(preg_match('/^(\d{4})-(\d{2})-(\d{2})(T|\s)(\d{2}):(\d{2}):(\d{2})(Z|(\+|-|\s)\d{2}(:?\d{2})?)$/', $value) > 0)) {
            $this->createViolation($constraint);
        } else {
            $dateTime = DateTime::createFromFormat(DateTime::ISO8601, $value);
            if ($value !== $dateTime->format(DateTime::ISO8601)) {
                $this->createViolation($constraint);
            }
        }
    }

    /**
     * Creates a violation
     * @param Constraint $constraint
     */
    private function createViolation(Constraint $constraint) {
        $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }
}
