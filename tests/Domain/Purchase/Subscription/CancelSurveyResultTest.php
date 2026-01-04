<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CancelSurveyResult;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CancelSurveyResultTest extends TestCase
{
    #[Test]
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

        $actual = $this->normalizer->normalize(compact('reason', 'reasonUserInput'), CancelSurveyResult::class);

        $this->assertInstanceOf(CancelSurveyResult::class, $actual);
        $this->assertSame($reason, $actual->reason->value);
        $this->assertSame($reasonUserInput, $actual->reasonUserInput);
    }

    #[Test]
    public function user_input_is_optional(): void
    {
        $data = ['reason' => 'CANCEL_SURVEY_REASON_UNSPECIFIED'];

        $actual = $this->normalizer->normalize($data, CancelSurveyResult::class);

        $this->assertNull($actual->reasonUserInput);
    }
}
