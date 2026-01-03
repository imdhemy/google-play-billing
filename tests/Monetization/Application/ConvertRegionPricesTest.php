<?php

declare(strict_types=1);

namespace Tests\Monetization\Application;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Tests\TestCase;

class ConvertRegionPricesTest extends TestCase
{
    /** @test */
    public function execute(): void
    {
        $packageName = 'com.some.thing';

        $data = [
            'currencyCode' => $this->faker->currencyCode(),
            'units' => (string)$this->faker->randomNumber(5),
            'nanos' => $this->faker->randomNumber(5),
        ];

        $money = $this->normalizer->normalize(data: $data, type: Money::class);

        $history = [];

        $client = $this->mockClient(responses: [new Response()], history: $history);

        $sut = new ConvertRegionPrices(client: $client, serializer: $this->serializer);

        $sut->execute(packageName: $packageName, price: $money);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: sprintf(
                    'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/pricing:convertRegionPrices',
                    $packageName
                ),
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: $this->serializer->serialize(data: [
                    'price' => $money,
                ]),
            ),
        );
    }
}
