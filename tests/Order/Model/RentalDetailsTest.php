<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\RentalDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RentalDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $data = $this->faker->rentalDetailsPayload();

        $rentalDetails = $this->normalizer->normalize(data: $data, type: RentalDetails::class);

        $this->assertEquals(new RentalDetails(), $rentalDetails);
    }
}
