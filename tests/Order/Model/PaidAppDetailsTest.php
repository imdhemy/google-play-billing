<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\PaidAppDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PaidAppDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $response = new Response(body: '{}');

        $paidAppDetails = $this->normalizer->normalize(data: $response, type: PaidAppDetails::class);

        $this->assertEquals(new PaidAppDetails(), $paidAppDetails);
    }
}
