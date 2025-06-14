<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

enum ConsumptionState: int
{
    case YET_TO_BE_CONSUMED = 0;
    case CONSUMED = 1;
}
