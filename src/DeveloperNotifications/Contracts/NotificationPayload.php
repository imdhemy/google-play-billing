<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Contracts;

/**
 * Interface Notification
 */
interface NotificationPayload
{
    public const ONE_TIME_PRODUCT_NOTIFICATION = 'oneTimeProductNotification';
    public const SUBSCRIPTION_NOTIFICATION = 'subscriptionNotification';
    public const TEST_NOTIFICATION = 'testNotification';

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return string
     */
    public function getType(): string;
}
