<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn;

enum RefundType: int
{
    case REFUND_TYPE_FULL_REFUND = 1;
    case REFUND_TYPE_QUANTITY_BASED_PARTIAL_REFUND = 2;
}
