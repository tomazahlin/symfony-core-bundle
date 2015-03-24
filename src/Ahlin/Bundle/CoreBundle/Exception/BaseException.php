<?php

namespace Ahlin\Bundle\CoreBundle\Exception;

use Exception;

/**
 * Class BaseException
 * The purpose of this exception is to be the base exception of all other exceptions
 */
class BaseException extends Exception
{
    public function __construct($message = '', $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
