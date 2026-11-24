<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\BaseDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class BaseDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $data = $this->faker->baseDetailsPayload();

        $baseDetails = $this->normalizer->normalize(data: $data, type: BaseDetails::class);

        $this->assertEquals(new BaseDetails(), $baseDetails);
    }
}
