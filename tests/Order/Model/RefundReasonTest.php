<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\RefundReason;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RefundReasonTest extends TestCase
{
    /**
     * @return iterable<string, array{string, RefundReason}>
     */
    public static function documentedValues(): iterable
    {
        yield 'REFUND_REASON_UNSPECIFIED' => ['REFUND_REASON_UNSPECIFIED', RefundReason::UNSPECIFIED];
        yield 'OTHER' => ['OTHER', RefundReason::OTHER];
        yield 'CHARGEBACK' => ['CHARGEBACK', RefundReason::CHARGEBACK];
    }

    #[Test]
    #[DataProvider('documentedValues')]
    public function it_normalizes_every_documented_value(string $value, RefundReason $expected): void
    {
        $response = new Response(body: json_encode($value, JSON_THROW_ON_ERROR));

        $refundReason = $this->normalizer->normalize(data: $response, type: RefundReason::class);

        $this->assertSame($expected, $refundReason);
    }
}
