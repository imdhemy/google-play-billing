<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\Cancellation;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionCancelSurveyResult;
use Tests\TestCase;

class CancellationTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_instantiated_from_an_array()
    {
        $cancelReason = $this->getRandomCancelReason();
        $userCancellationTime = $this->faker->unixTime();
        $cancelSurveyResult = [SubscriptionCancelSurveyResult::ATTR_CANCEL_SURVEY_REASON => $cancelReason,];

        $cancellation = Cancellation::fromArray([
            Cancellation::ATTR_CANCEL_REASON => $cancelReason,
            Cancellation::ATTR_USER_CANCELLATION_TIME_MILLIS => $userCancellationTime,
            Cancellation::ATTR_cancelSurveyResult => $cancelSurveyResult,
        ]);

        $this->assertInstanceOf(Cancellation::class, $cancellation);
    }

    /**
     * @test
     */
    public function it_can_check_if_cancelled()
    {
        $notCancelled = Cancellation::fromArray();
        $this->assertFalse($notCancelled->isCancelled());

        $cancelled = Cancellation::fromArray([Cancellation::ATTR_CANCEL_REASON => $this->getRandomCancelReason()]);
        $this->assertTrue($cancelled->isCancelled());
    }

    /**
     * @test
     */
    public function it_can_get_cancel_reason()
    {
        $randomCancelReason = $this->getRandomCancelReason();
        $cancellation = Cancellation::fromArray([Cancellation::ATTR_CANCEL_REASON => $randomCancelReason]);
        $this->assertEquals($randomCancelReason, $cancellation->getCancelReason());
    }

    /**
     * @test
     */
    public function it_can_get_user_cancellation_time()
    {
        $randomCancelReason = $this->getRandomCancelReason();
        $time = time() * 1000;
        $cancellation = Cancellation::fromArray([
            Cancellation::ATTR_CANCEL_REASON => $randomCancelReason,
            Cancellation::ATTR_USER_CANCELLATION_TIME_MILLIS => $time,
        ]);

        $this->assertEquals(
            $time,
            $cancellation->getUserCancellationTime()->getCarbon()->getTimestampMs()
        );

        $cancellation = Cancellation::fromArray([]);
        $this->assertNull($cancellation->getUserCancellationTime());
    }

    /**
     * @test
     */
    public function it_can_get_subscription_cancel_survey_result()
    {
        $cancelReason = $this->getRandomCancelReason();
        $userCancellationTime = $this->faker->unixTime();
        $cancelSurveyResult = [
            SubscriptionCancelSurveyResult::ATTR_CANCEL_SURVEY_REASON => $cancelReason,
            SubscriptionCancelSurveyResult::ATTR_USER_INPUT_CANCEL_REASON => null,
        ];

        $cancellation = Cancellation::fromArray([
            Cancellation::ATTR_CANCEL_REASON => $cancelReason,
            Cancellation::ATTR_USER_CANCELLATION_TIME_MILLIS => $userCancellationTime,
            Cancellation::ATTR_cancelSurveyResult => $cancelSurveyResult,
        ]);

        $this->assertEquals(
            $cancelSurveyResult,
            $cancellation->getCancelSurveyResult()->toArray()
        );

        $cancellation = Cancellation::fromArray([]);
        $this->assertNull($cancellation->getCancelSurveyResult());
    }

    /**
     * @return mixed
     */
    private function getRandomCancelReason()
    {
        return $this->faker->randomElement([
            Cancellation::CANCEL_REASON_BY_USER,
            Cancellation::CANCEL_REASON_BY_SYSTEM,
            Cancellation::CANCEL_REASON_REPLACED,
            Cancellation::CANCEL_REASON_BY_DEVELOPER,
        ]);
    }
}
