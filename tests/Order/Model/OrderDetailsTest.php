<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\OrderDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->orderDetailsPayload();

        $orderDetails = $this->normalizer->normalize(data: $data, type: OrderDetails::class);

        $this->assertEquals(new OrderDetails(taxInclusive: true), $orderDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $orderDetails = $this->normalizer->normalize(data: [], type: OrderDetails::class);

        $this->assertEquals(new OrderDetails(), $orderDetails);
    }
}
