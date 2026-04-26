<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Provider\Base;

final class RtdnProvider extends Base
{
    public function cloudMessage(array $data): array
    {
        return [
            'message' => [
                'data' => base64_encode(json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR)),
                'messageId' => '136969346945',
            ],
            'subscription' => 'projects/myproject/subscriptions/mysubscription',
        ];
    }

    public function testNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.app',
            'eventTimeMillis' => '1503349566168',
            'testNotification' => [
                'version' => '1.0',
            ],
        ];
    }

    public function voidedPurchaseNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.app',
            'eventTimeMillis' => '1503349566168',
            'voidedPurchaseNotification' => [
                'purchaseToken' => 'PURCHASE_TOKEN',
                'orderId' => 'GS.0000-0000-0000',
                'productType' => 1,
                'refundType' => 1,
            ],
        ];
    }

    public function oneTimeProductNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1503349566168',
            'oneTimeProductNotification' => [
                'version' => '1.0',
                'notificationType' => 1,
                'purchaseToken' => 'PURCHASE_TOKEN',
                'sku' => 'my.sku',
            ],
        ];
    }

    public function subscriptionNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1503349566168',
            'subscriptionNotification' => [
                'version' => '1.0',
                'notificationType' => 4,
                'purchaseToken' => 'PURCHASE_TOKEN',
            ],
        ];
    }
}
