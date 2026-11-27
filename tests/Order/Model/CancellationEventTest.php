<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use Imdhemy\GooglePlay\Order\Model\CancellationEvent;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CancellationEventTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->cancellationEventPayload();

        $cancellationEvent = $this->normalizer->normalize(data: $data, type: CancellationEvent::class);

        $this->assertEquals(new CancellationEvent(eventTime: new DateTimeImmutable('2026-01-08T00:00:00Z')), $cancellationEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $cancellationEvent = $this->normalizer->normalize(data: [], type: CancellationEvent::class);

        $this->assertEquals(new CancellationEvent(), $cancellationEvent);
    }
}
