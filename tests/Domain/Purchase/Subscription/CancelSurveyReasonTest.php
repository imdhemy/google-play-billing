<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CancelSurveyReason;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CancelSurveyReasonTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(CancelSurveyReason::class);

        $actual = $this->normalizer->normalize($value, CancelSurveyReason::class);

        $this->assertInstanceOf(CancelSurveyReason::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
