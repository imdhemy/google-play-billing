<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SystemInitiatedCancellation;
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
