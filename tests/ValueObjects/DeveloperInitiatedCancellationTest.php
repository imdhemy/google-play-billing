<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\DeveloperInitiatedCancellation;
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
