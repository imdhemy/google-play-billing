<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\PartialRefundState;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PartialRefundStateTest extends TestCase
{
    /**
     * @return iterable<string, array{string, PartialRefundState}>
     */
    public static function documentedValues(): iterable
    {
        yield 'STATE_UNSPECIFIED' => ['STATE_UNSPECIFIED', PartialRefundState::UNSPECIFIED];
        yield 'PENDING' => ['PENDING', PartialRefundState::PENDING];
        yield 'PROCESSED_SUCCESSFULLY' => ['PROCESSED_SUCCESSFULLY', PartialRefundState::PROCESSED_SUCCESSFULLY];
    }

    #[Test]
    #[DataProvider('documentedValues')]
    public function it_normalizes_every_documented_value(string $value, PartialRefundState $expected): void
    {
        $response = new Response(body: json_encode($value, JSON_THROW_ON_ERROR));

        $partialRefundState = $this->normalizer->normalize(data: $response, type: PartialRefundState::class);

        $this->assertSame($expected, $partialRefundState);
    }
}
