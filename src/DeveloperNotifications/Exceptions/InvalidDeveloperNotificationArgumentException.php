<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Exceptions;

use Imdhemy\GooglePlay\DeveloperNotifications\Builders\DeveloperNotificationBuilder;
use InvalidArgumentException;
use TypeError;

/**
 * Class InvalidDeveloperNotificationArgumentException
 */
class InvalidDeveloperNotificationArgumentException extends InvalidArgumentException
{
    /**
     * @param TypeError $typeError
     * @return InvalidDeveloperNotificationArgumentException
     */
    public static function fromTypeError(TypeError $typeError): InvalidDeveloperNotificationArgumentException
    {
        $message = $typeError->getMessage();
        $pattern = "/::get[a-z A-Z]+\(\)/";

        if (preg_match($pattern, $message, $matches)) {
            $propertyName = strtolower(str_replace(['::', 'get', '()'], '', $matches[0]));
            $setterName = sprintf('set%s', ucfirst($propertyName));
            $message = sprintf(
                'The property `%s` is required, use the %s::%s() to set it',
                $propertyName,
                DeveloperNotificationBuilder::class,
                $setterName
            );
        }

        return new self($message);
    }
}
