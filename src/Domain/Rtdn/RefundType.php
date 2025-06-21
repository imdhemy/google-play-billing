<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum RefundType: int
{
    case FULL_REFUND = 1;
    case QUANTITY_BASED_PARTIAL_REFUND = 2;
}
