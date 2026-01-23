<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use RuntimeException;
use Throwable;

final class MonetizationException extends RuntimeException
{
    public static function conversionFailed(Throwable $previous): self
    {
        return new self(message: 'Failed to convert region prices.', previous: $previous);
    }
}
