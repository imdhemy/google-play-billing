<?php

namespace Tests\DeveloperNotifications\Builders;

use Imdhemy\GooglePlay\DeveloperNotifications\Builders\DeveloperNotificationBuilder;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;
use Tests\TestCase;

/**
 * Class DeveloperNotificationBuilderTest
 */
class DeveloperNotificationBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_create_a_developer_notification()
    {
        $builder = DeveloperNotificationBuilder::init();
        $builder->setVersion('1.0')
            ->setEventTimeMillis(time())
            ->setPackageName('com.some.thing')
            ->setPayload(new TestNotification('1.0'));
        $this->assertInstanceOf(DeveloperNotification::class, $builder->build());
    }

    /**
     * @test
     */
    public function test_any_method_attribute_throws_exception()
    {
        $this->expectException(InvalidDeveloperNotificationArgumentException::class);
        DeveloperNotificationBuilder::init()->build();
    }
}
