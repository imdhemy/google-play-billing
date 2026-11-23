<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\OrderState;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderStateTest extends TestCase
{
    /**
     * @return iterable<string, array{string, OrderState}>
     */
    public static function documentedValues(): iterable
    {
        yield 'STATE_UNSPECIFIED' => ['STATE_UNSPECIFIED', OrderState::UNSPECIFIED];
        yield 'PENDING' => ['PENDING', OrderState::PENDING];
        yield 'PROCESSED' => ['PROCESSED', OrderState::PROCESSED];
        yield 'CANCELED' => ['CANCELED', OrderState::CANCELED];
        yield 'PENDING_REFUND' => ['PENDING_REFUND', OrderState::PENDING_REFUND];
        yield 'PARTIALLY_REFUNDED' => ['PARTIALLY_REFUNDED', OrderState::PARTIALLY_REFUNDED];
        yield 'REFUNDED' => ['REFUNDED', OrderState::REFUNDED];
    }

    #[Test]
    #[DataProvider('documentedValues')]
    public function it_normalizes_every_documented_value(string $value, OrderState $expected): void
    {
        $response = new Response(body: json_encode($value, JSON_THROW_ON_ERROR));

        $orderState = $this->normalizer->normalize(data: $response, type: OrderState::class);

        $this->assertSame($expected, $orderState);
    }
}
