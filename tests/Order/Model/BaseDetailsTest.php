<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\BaseDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class BaseDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $response = new Response(body: '{}');

        $baseDetails = $this->normalizer->normalize(data: $response, type: BaseDetails::class);

        $this->assertEquals(new BaseDetails(), $baseDetails);
    }
}
