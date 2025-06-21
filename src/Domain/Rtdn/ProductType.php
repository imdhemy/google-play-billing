<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum ProductType: int
{
    case PRODUCT_TYPE_SUBSCRIPTION = 1;
    case PRODUCT_TYPE_ONE_TIME = 2;
}
