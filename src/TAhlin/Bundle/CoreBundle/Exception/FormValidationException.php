<?php

namespace TAhlin\Bundle\CoreBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class FormValidationException
 * The purpose of this exception is to be thrown when a submitted form is not valid. It can contain multiple error messages.
 */
class FormValidationException extends FormHandlerException
{
    const MESSAGE = 'Validation error.';

    /**
     * @var array
     */
    private $errors = array();

    function __construct($message = self::MESSAGE)
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param string $field
     * @param string $message
     * @return $this
     */
    public function setError($field, $message = 'This value is not valid.')
    {
        $this->errors = array($field => $message);
        return $this;
    }

    /**
     * Set errors from the form
     * @param array $errors
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
