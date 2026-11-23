<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\PreorderDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PreorderDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $response = new Response(body: '{}');

        $preorderDetails = $this->normalizer->normalize(data: $response, type: PreorderDetails::class);

        $this->assertEquals(new PreorderDetails(), $preorderDetails);
    }
}
