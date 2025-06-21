<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SystemInitiatedCancellation;
use Tests\TestCase;

final class SystemInitiatedCancellationTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $actual = $this->normalizer->normalize([], SystemInitiatedCancellation::class);

        $this->assertInstanceOf(SystemInitiatedCancellation::class, $actual);
    }
}
