<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;

use RuntimeException;
use Throwable;

final class ConvertRegionPricesException extends RuntimeException
{
    public static function failed(Throwable $previous): self
    {
        return new self(message: 'Failed to convert region prices.', previous: $previous);
    }
}
