<?php

declare(strict_types=1);

namespace Tests\Monetization\Domain;

use Imdhemy\GooglePlay\Monetization\Domain\ConvertedOtherRegionsPrice;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ConvertedOtherRegionsPriceTest extends TestCase
{
    #[test]
    public function instantiate(): void
    {
        $data = [
            'usdPrice' => [
                'currencyCode' => 'USD',
                'units' => '4',
                'nanos' => 490000000,
            ],
            'eurPrice' => [
                'currencyCode' => 'EUR',
                'units' => '0',
                'nanos' => 0,
            ],
        ];

        $actual = $this->normalizer->normalize($data, ConvertedOtherRegionsPrice::class);

        $this->assertInstanceOf(ConvertedOtherRegionsPrice::class, $actual);
        $this->assertEquals(new Money('USD', '4', 490000000), $actual->usdPrice);
        $this->assertEquals(new Money('EUR', '0', 0), $actual->eurPrice);
    }
}
