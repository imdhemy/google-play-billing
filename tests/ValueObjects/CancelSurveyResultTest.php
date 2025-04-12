<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\CancelSurveyResult;
use Tests\TestCase;

final class CancelSurveyResultTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $reason = $this->faker->randomElement([
            'CANCEL_SURVEY_REASON_UNSPECIFIED',
            'CANCEL_SURVEY_REASON_NOT_ENOUGH_USAGE',
            'CANCEL_SURVEY_REASON_TECHNICAL_ISSUES',
            'CANCEL_SURVEY_REASON_COST_RELATED',
            'CANCEL_SURVEY_REASON_FOUND_BETTER_APP',
            'CANCEL_SURVEY_REASON_OTHERS',
        ]);
        $reasonUserInput = $this->faker->realText();

        $actual = $this->normalizer->normalize(\compact('reason', 'reasonUserInput'), CancelSurveyResult::class);

        $this->assertInstanceOf(CancelSurveyResult::class, $actual);
        $this->assertSame($reason, $actual->reason->value);
        $this->assertSame($reasonUserInput, $actual->reasonUserInput);
    }
}
