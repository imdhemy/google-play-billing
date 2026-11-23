<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\RefundDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RefundDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"total":{"currencyCode":"EUR","units":"4","nanos":0},"tax":{"currencyCode":"EUR","units":"0","nanos":690000000}}');

        $refundDetails = $this->normalizer->normalize(data: $response, type: RefundDetails::class);

        $this->assertEquals(new RefundDetails(total: new Money('EUR', '4', 0), tax: new Money('EUR', '0', 690000000)), $refundDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $refundDetails = $this->normalizer->normalize(data: $response, type: RefundDetails::class);

        $this->assertEquals(new RefundDetails(), $refundDetails);
    }
}
