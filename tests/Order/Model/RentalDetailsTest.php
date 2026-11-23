<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\RentalDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RentalDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $response = new Response(body: '{}');

        $rentalDetails = $this->normalizer->normalize(data: $response, type: RentalDetails::class);

        $this->assertEquals(new RentalDetails(), $rentalDetails);
    }
}
