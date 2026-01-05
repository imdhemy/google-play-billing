<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\PendingCancellation;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PendingCancellationTest extends TestCase
{
    #[Test]
    public function instantiation_with_no_fields(): void
    {
        $actual = $this->normalizer->normalize([], PendingCancellation::class);

        $this->assertInstanceOf(PendingCancellation::class, $actual);
    }
}
