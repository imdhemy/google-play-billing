<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\RefundDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RefundDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->refundDetailsPayload();

        $refundDetails = $this->normalizer->normalize(data: $data, type: RefundDetails::class);

        $this->assertEquals(new RefundDetails(total: new Money('EUR', '4', 0), tax: new Money('EUR', '0', 690000000)), $refundDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $refundDetails = $this->normalizer->normalize(data: [], type: RefundDetails::class);

        $this->assertEquals(new RefundDetails(), $refundDetails);
    }
}
