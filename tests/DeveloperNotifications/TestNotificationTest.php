<?php

namespace Tests\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;
use Tests\TestCase;

class TestNotificationTest extends TestCase
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var string[]
     */
    private $data;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->version = $this->faker->semver();
        $this->data = ['version' => $this->version];
    }

    /**
     * @test
     */
    public function test_create()
    {
        $payload = TestNotification::create($this->data);
        $this->assertInstanceOf(TestNotification::class, $payload);
    }

    /**
     * @test
     */
    public function test_get_version()
    {
        $payload = TestNotification::create($this->data);
        $this->assertEquals($this->version, $payload->getVersion());
    }

    /**
     * @test
     */
    public function test_get_type()
    {
        $payload = TestNotification::create($this->data);
        $this->assertEquals(NotificationPayload::TEST_NOTIFICATION, $payload->getType());
    }
}
