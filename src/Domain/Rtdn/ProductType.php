<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum ProductType: int
{
    case SUBSCRIPTION = 1;
    case ONE_TIME = 2;
}
