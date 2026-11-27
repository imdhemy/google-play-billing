<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\PaidAppDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PaidAppDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $data = $this->faker->paidAppDetailsPayload();

        $paidAppDetails = $this->normalizer->normalize(data: $data, type: PaidAppDetails::class);

        $this->assertEquals(new PaidAppDetails(), $paidAppDetails);
    }
}
