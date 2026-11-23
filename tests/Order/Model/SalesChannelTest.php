<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\SalesChannel;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SalesChannelTest extends TestCase
{
    /**
     * @return iterable<string, array{string, SalesChannel}>
     */
    public static function documentedValues(): iterable
    {
        yield 'SALES_CHANNEL_UNSPECIFIED' => ['SALES_CHANNEL_UNSPECIFIED', SalesChannel::UNSPECIFIED];
        yield 'IN_APP' => ['IN_APP', SalesChannel::IN_APP];
        yield 'PC_EMULATOR' => ['PC_EMULATOR', SalesChannel::PC_EMULATOR];
        yield 'NATIVE_PC' => ['NATIVE_PC', SalesChannel::NATIVE_PC];
        yield 'PLAY_STORE' => ['PLAY_STORE', SalesChannel::PLAY_STORE];
        yield 'OUTSIDE_PLAY_STORE' => ['OUTSIDE_PLAY_STORE', SalesChannel::OUTSIDE_PLAY_STORE];
    }

    #[Test]
    #[DataProvider('documentedValues')]
    public function it_normalizes_every_documented_value(string $value, SalesChannel $expected): void
    {
        $response = new Response(body: json_encode($value, JSON_THROW_ON_ERROR));

        $salesChannel = $this->normalizer->normalize(data: $response, type: SalesChannel::class);

        $this->assertSame($expected, $salesChannel);
    }
}
