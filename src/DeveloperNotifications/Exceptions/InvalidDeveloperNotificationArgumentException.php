<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Exceptions;

use InvalidArgumentException;
use TypeError;

/**
 * Class InvalidDeveloperNotificationArgumentException
 * @package Imdhemy\GooglePlay\DeveloperNotifications\Exceptions
 */
class InvalidDeveloperNotificationArgumentException extends InvalidArgumentException
{
    /**
     * @param TypeError $typeError
     * @return static
     */
    public static function fromTypeError(TypeError $typeError): self
    {
        $originalMessage = $typeError->getMessage();

        $message = str_replace('Return value of', 'Use', $originalMessage);
        $message = str_replace('get', 'set', $message);
        $message = str_replace('must be', 'with argument', $message);
        $message = str_replace(', null returned', '', $message);

        return new self($message);
    }
}
