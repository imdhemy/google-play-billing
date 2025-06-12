<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\PendingCancellation;
use Tests\TestCase;

final class PendingCancellationTest extends TestCase
{
    /** @test */
    public function instantiation_with_no_fields(): void
    {
        $actual = $this->normalizer->normalize([], PendingCancellation::class);

        $this->assertInstanceOf(PendingCancellation::class, $actual);
    }
}
