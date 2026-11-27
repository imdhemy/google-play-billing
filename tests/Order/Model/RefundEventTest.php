<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
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
        $data = $this->faker->refundEventPayload();

        $refundEvent = $this->normalizer->normalize(data: $data, type: RefundEvent::class);

        $this->assertEquals(new RefundEvent(
            eventTime: new DateTimeImmutable('2026-01-09T10:11:12.123456789Z'),
            refundDetails: new RefundDetails(total: new Money('EUR', '4', 0), tax: new Money('EUR', '0', 690000000)),
            refundReason: RefundReason::CHARGEBACK,
        ), $refundEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $refundEvent = $this->normalizer->normalize(data: [], type: RefundEvent::class);

        $this->assertEquals(new RefundEvent(), $refundEvent);
    }
}
