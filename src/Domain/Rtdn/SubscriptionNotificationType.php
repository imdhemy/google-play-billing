<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum SubscriptionNotificationType: int
{
    case RECOVERED = 1;
    case RENEWED = 2;
    case CANCELED = 3;
    case PURCHASED = 4;
    case ON_HOLD = 5;
    case IN_GRACE_PERIOD = 6;
    case RESTARTED = 7;
    case PRICE_CHANGE_CONFIRMED = 8; // Deprecated
    case DEFERRED = 9;
    case PAUSED = 10;
    case PAUSE_SCHEDULE_CHANGED = 11;
    case REVOKED = 12;
    case EXPIRED = 13;
    case PRICE_CHANGE_UPDATED = 19;
    case PENDING_PURCHASE_CANCELED = 20;
}
