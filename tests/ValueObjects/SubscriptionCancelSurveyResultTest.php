<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscriptionCancelSurveyResult;
use Tests\TestCase;

class SubscriptionCancelSurveyResultTest extends TestCase
{
    /**
     * @test
     */
    public function from_array()
    {
        $attr = [
            SubscriptionCancelSurveyResult::ATTR_CANCEL_SURVEY_REASON => 0,
            SubscriptionCancelSurveyResult::ATTR_USER_INPUT_CANCEL_REASON => $this->faker->sentence,
        ];

        $surveyResult = SubscriptionCancelSurveyResult::fromArray($attr);
        $this->assertInstanceOf(SubscriptionCancelSurveyResult::class, $surveyResult);
    }

    /**
     * @test
     */
    public function user_input_may_be_null()
    {
        $reason = SubscriptionCancelSurveyResult::CANCEL_SURVEY_REASON_NOT_USING_ENOUGH;
        $attr = [
            SubscriptionCancelSurveyResult::ATTR_CANCEL_SURVEY_REASON => $reason,
        ];

        $surveyResult = SubscriptionCancelSurveyResult::fromArray($attr);

        $this->assertNull($surveyResult->getUserInputCancelReason());
        $this->assertEquals($reason, $surveyResult->getCancelSurveyReason());
    }

    /**
     * @test
     */
    public function it_can_be_converted_into_an_array()
    {
        $attr = [
            SubscriptionCancelSurveyResult::ATTR_CANCEL_SURVEY_REASON => 0,
            SubscriptionCancelSurveyResult::ATTR_USER_INPUT_CANCEL_REASON => $this->faker->sentence,
        ];

        $surveyResult = SubscriptionCancelSurveyResult::fromArray($attr);
        $this->assertEquals($attr, $surveyResult->toArray());
    }
}
