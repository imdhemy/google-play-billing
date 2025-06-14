<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

enum ProductAcknowledgementState: int
{
    case NOT_ACKNOWLEDGED = 0;
    case ACKNOWLEDGED = 1;
}
