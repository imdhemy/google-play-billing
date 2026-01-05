<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\DeveloperInitiatedCancellation;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DeveloperInitiatedCancellationTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $actual = $this->normalizer->normalize([], DeveloperInitiatedCancellation::class);

        $this->assertInstanceOf(DeveloperInitiatedCancellation::class, $actual);
    }
}
