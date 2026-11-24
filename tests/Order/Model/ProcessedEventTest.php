<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use Imdhemy\GooglePlay\Order\Model\ProcessedEvent;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProcessedEventTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->processedEventPayload();

        $processedEvent = $this->normalizer->normalize(data: $data, type: ProcessedEvent::class);

        $this->assertEquals(new ProcessedEvent(eventTime: new DateTimeImmutable('2026-01-02T03:04:06Z')), $processedEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $processedEvent = $this->normalizer->normalize(data: [], type: ProcessedEvent::class);

        $this->assertEquals(new ProcessedEvent(), $processedEvent);
    }
}
