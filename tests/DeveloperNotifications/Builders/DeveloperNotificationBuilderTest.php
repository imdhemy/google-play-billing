<?php

namespace Tests\DeveloperNotifications\Builders;

use Imdhemy\GooglePlay\DeveloperNotifications\Builders\DeveloperNotificationBuilder;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Class DeveloperNotificationBuilderTest.
 */
class DeveloperNotificationBuilderTest extends TestCase
{
    #[Test]
    public function it_can_create_a_developer_notification(): void
    {
        $builder = DeveloperNotificationBuilder::init();

        $builder->setVersion('1.0')
            ->setEventTimeMillis(time())
            ->setPackageName('com.some.thing')
            ->setPayload(new TestNotification('1.0'))
            ->setDecodedData(['version' => '1.0']);

        $this->assertInstanceOf(DeveloperNotification::class, $builder->build());
    }

    #[Test]
    public function any_method_attribute_throws_exception(): void
    {
        $this->expectException(InvalidDeveloperNotificationArgumentException::class);

        DeveloperNotificationBuilder::init()->build();
    }
}
