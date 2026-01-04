<?php

namespace Imdhemy\GooglePlay\Monetization\Domain\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;

final class ConvertRegionPricesException extends RuntimeException
{
    public static function fromClient(ClientExceptionInterface $e): self
    {
        return new self('Client error while converting region prices: '.$e->getMessage(), previous: $e);
    }
}
