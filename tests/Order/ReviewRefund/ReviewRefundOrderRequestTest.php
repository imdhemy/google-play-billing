<?php

declare(strict_types=1);

namespace Tests\Order\ReviewRefund;

use Imdhemy\GooglePlay\Order\Model\ConsumptionUsageEvent;
use Imdhemy\GooglePlay\Order\Model\RefundPreference;
use Imdhemy\GooglePlay\Order\ReviewRefund\ReviewRefundOrderRequest;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ReviewRefundOrderRequestTest extends TestCase
{
    #[Test]
    #[DataProvider('provide_valid_consumption_percentages')]
    public function it_accepts_a_consumption_percentage_within_the_documented_range(int $milliunits): void
    {
        $request = $this->createRequest(consumptionPercentageMilliunits: $milliunits);

        $this->assertSame($milliunits, $request->consumptionPercentageMilliunits);
    }

    public static function provide_valid_consumption_percentages(): iterable
    {
        yield 'zero' => [0];
        yield 'maximum' => [100_000];
    }

    #[Test]
    #[DataProvider('provide_invalid_consumption_percentages')]
    public function it_rejects_a_consumption_percentage_outside_the_documented_range(int $milliunits): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The consumption percentage must be between 0 and 100000 milliunits.');

        $this->createRequest(consumptionPercentageMilliunits: $milliunits);
    }

    public static function provide_invalid_consumption_percentages(): iterable
    {
        yield 'negative' => [-1];
        yield 'above maximum' => [100_001];
    }

    #[Test]
    public function it_accepts_up_to_one_thousand_consumption_usage_events(): void
    {
        $events = array_fill(0, 1_000, new ConsumptionUsageEvent());

        $request = $this->createRequest(consumptionUsageEvents: $events);

        $this->assertCount(1_000, $request->consumptionUsageEvents);
    }

    #[Test]
    public function it_rejects_more_than_one_thousand_consumption_usage_events(): void
    {
        $events = array_fill(0, 1_001, new ConsumptionUsageEvent());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('At most 1000 consumption usage events are allowed.');

        $this->createRequest(consumptionUsageEvents: $events);
    }

    /**
     * @param list<ConsumptionUsageEvent> $consumptionUsageEvents
     */
    private function createRequest(
        ?int $consumptionPercentageMilliunits = null,
        array $consumptionUsageEvents = [],
    ): ReviewRefundOrderRequest {
        return new ReviewRefundOrderRequest(
            packageName: 'com.example.app',
            orderId: 'GPA.1234-5678-9012-34567',
            pendingRefundToken: 'pending-refund-token',
            sampleContentProvided: false,
            refundPreference: RefundPreference::NEUTRAL,
            consumptionPercentageMilliunits: $consumptionPercentageMilliunits,
            consumptionUsageEvents: $consumptionUsageEvents,
        );
    }
}
