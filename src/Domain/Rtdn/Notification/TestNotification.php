<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#test
 */
final readonly class TestNotification
{
    public function __construct(public string $version)
    {
    }
}
