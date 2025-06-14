<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\CancelSurveyReason;
use Tests\TestCase;

final class CancelSurveyReasonTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(CancelSurveyReason::class);

        $actual = $this->normalizer->normalize($value, CancelSurveyReason::class);

        $this->assertInstanceOf(CancelSurveyReason::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
