<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\PartialRefundEvent;
use Imdhemy\GooglePlay\Order\Model\PartialRefundState;
use Imdhemy\GooglePlay\Order\Model\RefundDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PartialRefundEventTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"createTime":"2026-01-05T00:00:00Z","processTime":"2026-01-06T00:00:00Z","state":"PENDING","refundDetails":{"tax":{"currencyCode":"EUR","units":"0","nanos":170000000}}}');

        $partialRefundEvent = $this->normalizer->normalize(data: $response, type: PartialRefundEvent::class);

        $this->assertEquals(new PartialRefundEvent(
            createTime: new DateTimeImmutable('2026-01-05T00:00:00Z'),
            processTime: new DateTimeImmutable('2026-01-06T00:00:00Z'),
            state: PartialRefundState::PENDING,
            refundDetails: new RefundDetails(tax: new Money('EUR', '0', 170000000)),
        ), $partialRefundEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $partialRefundEvent = $this->normalizer->normalize(data: $response, type: PartialRefundEvent::class);

        $this->assertEquals(new PartialRefundEvent(), $partialRefundEvent);
    }
}
