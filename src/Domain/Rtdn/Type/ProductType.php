<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Type;

enum ProductType: int
{
    case SUBSCRIPTION = 1;
    case ONE_TIME = 2;
}
