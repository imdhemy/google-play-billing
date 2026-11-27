<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FreeTrialDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $data = $this->faker->freeTrialDetailsPayload();

        $freeTrialDetails = $this->normalizer->normalize(data: $data, type: FreeTrialDetails::class);

        $this->assertEquals(new FreeTrialDetails(), $freeTrialDetails);
    }
}
