<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OneTimeCode;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OneTimeCodeTest extends TestCase
{
    #[Test]
    public function can_instantiate(): void
    {
        $actual = $this->normalizer->normalize([], OneTimeCode::class);

        $this->assertInstanceOf(OneTimeCode::class, $actual);
    }
}
