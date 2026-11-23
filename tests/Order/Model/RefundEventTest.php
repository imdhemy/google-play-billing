<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\RefundDetails;
use Imdhemy\GooglePlay\Order\Model\RefundEvent;
use Imdhemy\GooglePlay\Order\Model\RefundReason;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RefundEventTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"eventTime":"2026-01-09T10:11:12Z","refundDetails":{"total":{"currencyCode":"EUR","units":"4","nanos":0}},"refundReason":"OTHER"}');

        $refundEvent = $this->normalizer->normalize(data: $response, type: RefundEvent::class);

        $this->assertEquals(new RefundEvent(
            eventTime: new DateTimeImmutable('2026-01-09T10:11:12Z'),
            refundDetails: new RefundDetails(total: new Money('EUR', '4', 0)),
            refundReason: RefundReason::OTHER,
        ), $refundEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $refundEvent = $this->normalizer->normalize(data: $response, type: RefundEvent::class);

        $this->assertEquals(new RefundEvent(), $refundEvent);
    }
}
