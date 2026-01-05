<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ReplacementCancellation;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ReplacementCancellationTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $actual = $this->normalizer->normalize([], ReplacementCancellation::class);

        $this->assertInstanceOf(ReplacementCancellation::class, $actual);
    }
}
