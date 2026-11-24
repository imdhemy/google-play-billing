<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use Imdhemy\GooglePlay\Order\Model\CancellationEvent;
use Imdhemy\GooglePlay\Order\Model\OrderHistory;
use Imdhemy\GooglePlay\Order\Model\PartialRefundEvent;
use Imdhemy\GooglePlay\Order\Model\PartialRefundState;
use Imdhemy\GooglePlay\Order\Model\ProcessedEvent;
use Imdhemy\GooglePlay\Order\Model\RefundDetails;
use Imdhemy\GooglePlay\Order\Model\RefundEvent;
use Imdhemy\GooglePlay\Order\Model\RefundReason;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderHistoryTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->orderHistoryPayload();

        $orderHistory = $this->normalizer->normalize(data: $data, type: OrderHistory::class);

        $this->assertEquals(new OrderHistory(
            processedEvent: new ProcessedEvent(eventTime: new DateTimeImmutable('2026-01-02T03:04:06Z')),
            cancellationEvent: new CancellationEvent(eventTime: new DateTimeImmutable('2026-01-08T00:00:00Z')),
            refundEvent: new RefundEvent(
                eventTime: new DateTimeImmutable('2026-01-09T10:11:12.123456789Z'),
                refundDetails: new RefundDetails(total: new Money('EUR', '4', 0), tax: new Money('EUR', '0', 690000000)),
                refundReason: RefundReason::CHARGEBACK,
            ),
            partialRefundEvents: [new PartialRefundEvent(
                createTime: new DateTimeImmutable('2026-01-05T00:00:00Z'),
                processTime: new DateTimeImmutable('2026-01-06T00:00:00Z'),
                state: PartialRefundState::PROCESSED_SUCCESSFULLY,
                refundDetails: new RefundDetails(total: new Money('EUR', '1', 0), tax: new Money('EUR', '0', 170000000)),
            )],
        ), $orderHistory);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $orderHistory = $this->normalizer->normalize(data: [], type: OrderHistory::class);

        $this->assertEquals(new OrderHistory(), $orderHistory);
    }
}
