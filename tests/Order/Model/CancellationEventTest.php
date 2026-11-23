<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\CancellationEvent;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CancellationEventTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"eventTime":"2026-01-08T00:00:00Z"}');

        $cancellationEvent = $this->normalizer->normalize(data: $response, type: CancellationEvent::class);

        $this->assertEquals(new CancellationEvent(eventTime: new DateTimeImmutable('2026-01-08T00:00:00Z')), $cancellationEvent);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $cancellationEvent = $this->normalizer->normalize(data: $response, type: CancellationEvent::class);

        $this->assertEquals(new CancellationEvent(), $cancellationEvent);
    }
}
