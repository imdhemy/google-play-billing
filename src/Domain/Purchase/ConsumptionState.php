<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase;

enum ConsumptionState: int
{
    case NOT_CONSUMED = 0;
    case CONSUMED = 1;
}
