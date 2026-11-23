<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\CancellationEvent;
use Imdhemy\GooglePlay\Order\Model\OrderHistory;
use Imdhemy\GooglePlay\Order\Model\PartialRefundEvent;
use Imdhemy\GooglePlay\Order\Model\PartialRefundState;
use Imdhemy\GooglePlay\Order\Model\ProcessedEvent;
use Imdhemy\GooglePlay\Order\Model\RefundEvent;
use Imdhemy\GooglePlay\Order\Model\RefundReason;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderHistoryTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"processedEvent":{"eventTime":"2026-01-02T03:04:06Z"},"cancellationEvent":{"eventTime":"2026-01-08T00:00:00Z"},"refundEvent":{"refundReason":"CHARGEBACK"},"partialRefundEvents":[{"state":"PENDING"},{"state":"PROCESSED_SUCCESSFULLY"}]}');

        $orderHistory = $this->normalizer->normalize(data: $response, type: OrderHistory::class);

        $this->assertEquals(new OrderHistory(
            processedEvent: new ProcessedEvent(eventTime: new DateTimeImmutable('2026-01-02T03:04:06Z')),
            cancellationEvent: new CancellationEvent(eventTime: new DateTimeImmutable('2026-01-08T00:00:00Z')),
            refundEvent: new RefundEvent(refundReason: RefundReason::CHARGEBACK),
            partialRefundEvents: [
                new PartialRefundEvent(state: PartialRefundState::PENDING),
                new PartialRefundEvent(state: PartialRefundState::PROCESSED_SUCCESSFULLY),
            ],
        ), $orderHistory);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $orderHistory = $this->normalizer->normalize(data: $response, type: OrderHistory::class);

        $this->assertEquals(new OrderHistory(), $orderHistory);
    }
}
