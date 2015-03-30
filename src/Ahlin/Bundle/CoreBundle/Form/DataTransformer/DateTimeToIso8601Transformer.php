<?php

namespace Ahlin\Bundle\CoreBundle\Form\DataTransformer;

use DateTime;
use Exception;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTimeToIso8601Transformer implements DataTransformerInterface
{
    /**
     * Transforms an ISO8601 string to DateTime object.
     * @param  string $iso
     * @return DateTime
     * @throws TransformationFailedException
     */
    public function reverseTransform($iso)
    {
        try {
            return new DateTime($iso);
        }
        catch (Exception $e) {
            $exception = new TransformationFailedException();
            throw $exception;
        }
    }

    /**
     * Transformation will return ISO8601 format from the datetime
     * @param  DateTime $datetime
     * @return string
     * @throws TransformationFailedException
     */
    public function transform($datetime)
    {
        if (empty($datetime)) {
            return '';
        }

        if ($datetime instanceof DateTime) {
            return $datetime->format(DateTime::ISO8601);
        }

        $exception = new TransformationFailedException();
        throw $exception;
    }
}
