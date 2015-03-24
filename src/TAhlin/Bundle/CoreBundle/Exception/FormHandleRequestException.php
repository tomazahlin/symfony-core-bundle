<?php

namespace TAhlin\Bundle\CoreBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class FormHandleRequestException
 * The purpose of this exception is to be thrown before form validation occurs.
 */
class FormHandleRequestException extends FormHandlerException
{
    const MESSAGE = 'Entity pre-validation error.';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $fieldMessage;

    function __construct($field, $message)
    {
        $this->field = $field;
        $this->message = $message;
        parent::__construct(self::MESSAGE, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getFieldMessage()
    {
        return $this->fieldMessage;
    }
}
