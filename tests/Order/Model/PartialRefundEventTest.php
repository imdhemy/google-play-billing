<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
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
        $data = $this->faker->partialRefundEventPayload();

        $partialRefundEvent = $this->normalizer->normalize(data: $data, type: PartialRefundEvent::class);

        $this->assertEquals(new PartialRefundEvent(
            createTime: new DateTimeImmutable('2026-01-05T00:00:00Z'),
            processTime: new DateTimeImmutable('2026-01-06T00:00:00Z'),
            state: PartialRefundState::PROCESSED_SUCCESSFULLY,
            refundDetails: new RefundDetails(total: new Money('EUR', '1', 0), tax: new Money('EUR', '0', 170000000)),
        ), $partialRefundEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $partialRefundEvent = $this->normalizer->normalize(data: [], type: PartialRefundEvent::class);

        $this->assertEquals(new PartialRefundEvent(), $partialRefundEvent);
    }
}
