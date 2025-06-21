<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Product;

enum AcknowledgementState: int
{
    case NOT_ACKNOWLEDGED = 0;
    case ACKNOWLEDGED = 1;
}
