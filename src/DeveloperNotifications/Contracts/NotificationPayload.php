<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Contracts;

/**
 * Interface Notification
 *
 * @package Imdhemy\GooglePlay\DeveloperNotifications
 * @since 2.0.0
 */
interface NotificationPayload
{
    public const ONE_TIME_PRODUCT_NOTIFICATION = 'oneTimeProductNotification';
    public const SUBSCRIPTION_NOTIFICATION = 'subscriptionNotification';
    public const TEST_NOTIFICATION = 'testNotification';
    public const ONE_TIME_PRODUCT_CANCELED = 2;
    public const ONE_TIME_PRODUCT_PURCHASED = 1;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return string
     */
    public function getType(): string;
}
