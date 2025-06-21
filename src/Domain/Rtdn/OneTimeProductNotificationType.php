<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum OneTimeProductNotificationType: int
{
    case PURCHASED = 1;
    case CANCELED = 2;
}
