<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\PreorderDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PreorderDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $data = $this->faker->preorderDetailsPayload();

        $preorderDetails = $this->normalizer->normalize(data: $data, type: PreorderDetails::class);

        $this->assertEquals(new PreorderDetails(), $preorderDetails);
    }
}
