<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Product;

enum PurchaseState: int
{
    case PURCHASED = 0;
    case CANCELED = 1;
    case PENDING = 2;
}
