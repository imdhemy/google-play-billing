<?php

declare(strict_types=1);

namespace Tests\Dto;

use Imdhemy\GooglePlay\Dto\DeferSubscriptionResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DeferSubscriptionResponseTest extends TestCase
{
    #[test]
    public function instantiation(): void
    {
        $data = ['newExpiryTimeMillis' => '1776004800000'];

        $actual = $this->normalizer->normalize($data, DeferSubscriptionResponse::class);

        $this->assertInstanceOf(DeferSubscriptionResponse::class, $actual);
        $this->assertSame($data['newExpiryTimeMillis'], $actual->newExpiryTimeMillis->originalValue);
    }
}
