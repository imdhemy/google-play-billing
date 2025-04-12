<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\ReplacementCancellation;
use Tests\TestCase;

final class ReplacementCancellationTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $actual = $this->normalizer->normalize([], ReplacementCancellation::class);

        $this->assertInstanceOf(ReplacementCancellation::class, $actual);
    }
}
