<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\DeveloperInitiatedCancellation;
use Tests\TestCase;

final class DeveloperInitiatedCancellationTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $actual = $this->normalizer->normalize([], DeveloperInitiatedCancellation::class);

        $this->assertInstanceOf(DeveloperInitiatedCancellation::class, $actual);
    }
}
