<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Factories;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\OneTimePurchaseNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;

/**
 * Class NotificationPayloadFactory
 * This is tested on @link {Imdhemy\GooglePlay\Tests\DeveloperNotifications\DeveloperNotificationTest}
 */
class NotificationPayloadFactory
{
    /**
     * @param array $data
     * @return NotificationPayload
     */
    public static function create(array $data): NotificationPayload
    {
        if (isset($data[NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION])) {
            return OneTimePurchaseNotification::create($data[NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION]);
        }

        if (isset($data[NotificationPayload::SUBSCRIPTION_NOTIFICATION])) {
            return SubscriptionNotification::create($data[NotificationPayload::SUBSCRIPTION_NOTIFICATION]);
        }

        return new TestNotification($data['version']);
    }
}
