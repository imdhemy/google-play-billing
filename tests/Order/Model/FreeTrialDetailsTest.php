<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FreeTrialDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $response = new Response(body: '{}');

        $freeTrialDetails = $this->normalizer->normalize(data: $response, type: FreeTrialDetails::class);

        $this->assertEquals(new FreeTrialDetails(), $freeTrialDetails);
    }
}
