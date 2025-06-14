<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

enum ConsumptionState: int
{
    case NOT_CONSUMED = 0;
    case CONSUMED = 1;
}
