<?php

declare(strict_types=1);

namespace Tests\Interface\Rtdn;

use Imdhemy\GooglePlay\Domain\Rtdn\Notification\OneTimeProductNotification;
use Imdhemy\GooglePlay\Domain\Rtdn\Notification\SubscriptionNotification;
use Imdhemy\GooglePlay\Domain\Rtdn\Notification\TestNotification;
use Imdhemy\GooglePlay\Domain\Rtdn\Notification\VoidedPurchaseNotification;
use Imdhemy\GooglePlay\Interface\Rtdn\NotificationParser;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class NotificationParserTest extends TestCase
{
    #[Test]
    public function parse_test_notification(): void
    {
        $data = $this->faker->testNotificationPayload();
        $cloudMessage = $this->faker->cloudMessage($data);
        $sut = new NotificationParser($this->normalizer);

        $message = $sut->parse($cloudMessage);

        $this->assertSame($data['version'], $message->version);
        $this->assertSame($data['packageName'], $message->packageName);
        $this->assertSame($data['eventTimeMillis'], $message->eventTimeMillis->originalValue);
        $this->assertInstanceOf(TestNotification::class, $message->testNotification);
        $this->assertSame($data['version'], $message->testNotification->version);
        $this->assertNull($message->voidedPurchaseNotification);
        $this->assertNull($message->oneTimeProductNotification);
        $this->assertNull($message->subscriptionNotification);
    }

    #[Test]
    public function parse_voided_purchase_notification(): void
    {
        $data = $this->faker->voidedPurchaseNotificationPayload();
        $payload = $data['voidedPurchaseNotification'];
        $cloudMessage = $this->faker->cloudMessage($data);
        $sut = new NotificationParser($this->normalizer);

        $message = $sut->parse($cloudMessage);

        $this->assertInstanceOf(VoidedPurchaseNotification::class, $message->voidedPurchaseNotification);
        $this->assertNull($message->testNotification);
        $this->assertNull($message->oneTimeProductNotification);
        $this->assertEquals($payload['purchaseToken'], $message->voidedPurchaseNotification->purchaseToken);
        $this->assertEquals($payload['orderId'], $message->voidedPurchaseNotification->orderId);
        $this->assertEquals($payload['productType'], $message->voidedPurchaseNotification->productType->value);
        $this->assertEquals($payload['refundType'], $message->voidedPurchaseNotification->refundType->value);
    }

    #[Test]
    public function parse_one_time_product_notification(): void
    {
        $data = $this->faker->oneTimeProductNotificationPayload();
        $payload = $data['oneTimeProductNotification'];
        $cloudMessage = $this->faker->cloudMessage($data);
        $sut = new NotificationParser($this->normalizer);

        $message = $sut->parse($cloudMessage);

        $this->assertInstanceOf(OneTimeProductNotification::class, $message->oneTimeProductNotification);
        $this->assertNull($message->testNotification);
        $this->assertNull($message->voidedPurchaseNotification);
        $this->assertEquals($payload['version'], $message->oneTimeProductNotification->version);
        $this->assertEquals(
            $payload['notificationType'],
            $message->oneTimeProductNotification->notificationType->value
        );
        $this->assertEquals($payload['purchaseToken'], $message->oneTimeProductNotification->purchaseToken);
        $this->assertEquals($payload['sku'], $message->oneTimeProductNotification->sku);
    }

    #[Test]
    public function parse_subscription_notification(): void
    {
        $data = $this->faker->subscriptionNotificationPayload();
        $payload = $data['subscriptionNotification'];
        $cloudMessage = $this->faker->cloudMessage($data);
        $sut = new NotificationParser($this->normalizer);

        $message = $sut->parse($cloudMessage);

        $this->assertInstanceOf(SubscriptionNotification::class, $message->subscriptionNotification);
        $this->assertNull($message->testNotification);
        $this->assertNull($message->voidedPurchaseNotification);
        $this->assertNull($message->oneTimeProductNotification);
        $this->assertEquals($payload['version'], $message->subscriptionNotification->version);
        $this->assertEquals($payload['notificationType'], $message->subscriptionNotification->notificationType->value);
        $this->assertEquals($payload['purchaseToken'], $message->subscriptionNotification->purchaseToken);
    }
}
