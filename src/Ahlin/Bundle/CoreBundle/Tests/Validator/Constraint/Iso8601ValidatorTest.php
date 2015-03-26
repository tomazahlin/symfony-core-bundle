<?php

namespace Ahlin\Bundle\CoreBundle\Tests\Validator\Constraint;

use Ahlin\Bundle\CoreBundle\Validator\Constraint\Iso8601;
use Ahlin\Bundle\CoreBundle\Validator\Constraint\Iso8601Validator;
use DateTime;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;
use Symfony\Component\Validator\Validation;

const TEST = 1;

class Iso8601ValidatorTest extends AbstractConstraintValidatorTest
{
    protected function getApiVersion()
    {
        return Validation::API_VERSION_2_5;
    }

    protected function createValidator()
    {
        return new Iso8601Validator();
    }

    /**
     * Test that valid string dates in ISO8601 format do not produce violations
     * @dataProvider getValidStringDates
     * @group validation
     * @param array $date
     */
    public function testValidStringDates($date)
    {
        $constraint = new Iso8601();
        $this->validator->validate($date, $constraint);
        $this->assertNoViolation();
    }

    /**
     * Test that two bookings which do not overlap, result in no violation raised during validation
     * @dataProvider getInvalidStringDates
     * @group booking
     * @param array $date
     */
    public function testInvalidStringDates($date)
    {
        $constraint = new Iso8601();
        $this->validator->validate($date, $constraint);
        $this->buildViolation('Date is not in ISO8601 format.')->assertRaised();
    }

    // Data providers

    static function getValidStringDates()
    {
        return array(
            array('data' => '1988-12-06T00:00:00-0100'),
            array('data' => '2008-07-09T19:00:00+0100'),
            array('data' => '2015-02-09T09:00:00+0200'),
        );
    }

    static function getInvalidStringDates()
    {
        return array(
            array('data' => 'test'),                     # Invalid format
            array('data' => '1980-15-01T10:00:00+0100'), # Invalid month
            array('data' => '2000-AA-01T10:00:00+0100'), # Invalid month
            array('data' => '2015-01-01T10:00:00'),      # No timezone
            array('data' => '2015-01-60T10:00:00+0100'), # Invalid day
            array('data' => '2015-01-01T90:00:00+0100'), # Invalid hour
            array('data' => '2015-01-01T10:90:00+0100'), # Invalid minute
            array('data' => '2015-01-01T10:00:90+0100'), # Invalid second
            array('data' => '2015-01-01T10:00:00+9999'), # Invalid timezone
        );
    }
}