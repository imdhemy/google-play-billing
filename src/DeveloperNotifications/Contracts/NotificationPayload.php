<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Contracts;

/**
 * Interface Notification.
 */
interface NotificationPayload
{
    public const ONE_TIME_PRODUCT_NOTIFICATION = 'oneTimeProductNotification';
    public const SUBSCRIPTION_NOTIFICATION = 'subscriptionNotification';
    public const TEST_NOTIFICATION = 'testNotification';

    /**
     * Returns the notification version.
     */
    public function getVersion(): string;

    /**
     * Returns the payload type (one time product, subscription, test).
     */
    public function getType(): string;

    /**
     * Returns the notification actual type (e.g 1 for subscription recovered).
     */
    public function getNotificationType(): int;
}
