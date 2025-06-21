<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Type;

enum OneTimeProductNotificationType: int
{
    case PURCHASED = 1;
    case CANCELED = 2;
}
