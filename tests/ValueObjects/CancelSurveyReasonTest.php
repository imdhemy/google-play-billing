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
        $value = $this->faker->randomElement([
            'CANCEL_SURVEY_REASON_UNSPECIFIED',
            'CANCEL_SURVEY_REASON_NOT_ENOUGH_USAGE',
            'CANCEL_SURVEY_REASON_TECHNICAL_ISSUES',
            'CANCEL_SURVEY_REASON_COST_RELATED',
            'CANCEL_SURVEY_REASON_FOUND_BETTER_APP',
            'CANCEL_SURVEY_REASON_OTHERS',
        ]);

        $actual = $this->normalizer->normalize($value, CancelSurveyReason::class);

        $this->assertInstanceOf(CancelSurveyReason::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
