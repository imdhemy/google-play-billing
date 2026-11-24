<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\OneTimePurchaseDetails;
use Imdhemy\GooglePlay\Order\Model\PreorderDetails;
use Imdhemy\GooglePlay\Order\Model\RentalDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OneTimePurchaseDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->oneTimePurchaseDetailsPayload();

        $oneTimePurchaseDetails = $this->normalizer->normalize(data: $data, type: OneTimePurchaseDetails::class);

        $this->assertEquals(new OneTimePurchaseDetails(
            quantity: 3,
            offerId: 'bundle',
            purchaseOptionId: 'rent',
            rentalDetails: new RentalDetails(),
            preorderDetails: new PreorderDetails(),
        ), $oneTimePurchaseDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $oneTimePurchaseDetails = $this->normalizer->normalize(data: [], type: OneTimePurchaseDetails::class);

        $this->assertEquals(new OneTimePurchaseDetails(), $oneTimePurchaseDetails);
    }
}
