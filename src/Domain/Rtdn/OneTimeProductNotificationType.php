<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum OneTimeProductNotificationType: int
{
    case ONE_TIME_PRODUCT_PURCHASED = 1;
    case ONE_TIME_PRODUCT_CANCELED = 2;
}
