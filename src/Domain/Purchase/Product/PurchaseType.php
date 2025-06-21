<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Product;

enum PurchaseType: int
{
    case TEST = 0;
    case PROMO = 1;
    case REWARDED = 2;
}
