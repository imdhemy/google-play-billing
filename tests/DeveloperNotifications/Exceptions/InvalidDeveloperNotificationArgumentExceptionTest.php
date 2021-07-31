<?php

namespace Imdhemy\GooglePlay\Tests\DeveloperNotifications\Exceptions;

use Imdhemy\GooglePlay\DeveloperNotifications\Builders\DeveloperNotificationBuilder;
use Imdhemy\GooglePlay\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use Imdhemy\GooglePlay\Tests\TestCase;

/**
 * Class InvalidDeveloperNotificationArgumentExceptionTest
 * @package Imdhemy\GooglePlay\Tests\DeveloperNotifications\Exceptions
 */
class InvalidDeveloperNotificationArgumentExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function test_messages_are_descriptive()
    {
        try {
            DeveloperNotificationBuilder::init()->build();
        } catch (InvalidDeveloperNotificationArgumentException $exception) {
            $expectedMessage = sprintf(
                "Use %s::setVersion() with argument of the type string",
                DeveloperNotificationBuilder::class
            );
            $this->assertEquals($expectedMessage, $exception->getMessage());
        }
    }
}
