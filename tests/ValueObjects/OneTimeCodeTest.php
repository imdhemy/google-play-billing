<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\OneTimeCode;
use Tests\TestCase;

final class OneTimeCodeTest extends TestCase
{
    /** @test */
    public function can_instantiate(): void
    {
        $actual = $this->normalizer->normalize([], OneTimeCode::class);

        $this->assertInstanceOf(OneTimeCode::class, $actual);
    }
}
