<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionState;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SubscriptionStateTest extends TestCase
{
    #[test]
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(SubscriptionState::class);

        $actual = $this->normalizer->normalize($value, SubscriptionState::class);

        $this->assertInstanceOf(SubscriptionState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
