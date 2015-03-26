<?php

namespace Ahlin\Bundle\CoreBundle\Form\DataTransformer;

use DateTime;
use Exception;
use Ahlin\Bundle\CoreBundle\Exception\FormValidationException;
use Symfony\Component\Form\DataTransformerInterface;

class DateTimeToIso8601Transformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $formFieldName;

    /**
     * Constructor to set which form field should contain an error message if transformer fails
     * @param $formFieldName
     */
    function __construct($formFieldName)
    {
        $this->formFieldName = $formFieldName;
    }

    /**
     * Transforms an ISO8601 string to DateTime object.
     * @param  string $iso
     * @return DateTime
     * @throws FormValidationException
     */
    public function reverseTransform($iso)
    {
        try {
            return new DateTime($iso);
        }
        catch (Exception $e) {
            $exception = new FormValidationException();
            $exception->setError($this->formFieldName, 'Not an ISO8601 format.');
            throw $exception;
        }
    }

    /**
     * Transformation will return ISO8601 format from the datetime
     * @param  DateTime $datetime
     * @return string
     * @throws FormValidationException
     */
    public function transform($datetime)
    {
        if ($datetime instanceof DateTime) {
            return $datetime->format(DateTime::ISO8601);
        }
        $exception = new FormValidationException();
        $exception->setError($this->formFieldName, 'Not a DateTime object.');
        throw $exception;
    }
}
