<?php

namespace Ahlin\Bundle\CoreBundle\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ForbiddenBaseException
 * The purpose of this exception is to be represent a base exception for any forbidden exceptions.
 */
class ForbiddenBaseException extends BaseException
{
    function __construct($message, $code = Response::HTTP_FORBIDDEN, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
