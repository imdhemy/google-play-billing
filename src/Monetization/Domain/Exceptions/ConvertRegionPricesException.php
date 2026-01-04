<?php

namespace Imdhemy\GooglePlay\Monetization\Domain\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;

final class ConvertRegionPricesException extends RuntimeException
{
    public static function make(string $message): self
    {
        return new self('Error converting region prices: '.$message);
    }

    public static function fromClient(ClientExceptionInterface $e): self
    {
        return new self('Client error while converting region prices: '.$e->getMessage(), previous: $e);
    }
}
