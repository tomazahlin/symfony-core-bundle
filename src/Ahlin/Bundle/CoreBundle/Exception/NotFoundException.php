<?php

namespace Ahlin\Bundle\CoreBundle\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundException
 * The purpose of this exception is to be thrown when a resource cannot be loaded from database, because it is not found
 */
class NotFoundException extends BaseException
{
    function __construct($message, $code = Response::HTTP_NOT_FOUND, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
