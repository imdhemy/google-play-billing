<?php

namespace Tests\Normalizer;

use Imdhemy\GooglePlay\Normalizer\TimeNormalizer;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

final class TimeNormalizerTest extends TestCase
{
    /** @test */
    public function denormalize(): void
    {
        $zulu = '2021-09-01T00:00:00Z';
        $sut = new TimeNormalizer();

        $time = $sut->denormalize($zulu, Time::class);

        $this->assertEquals($zulu, $time->originalValue);
    }

    /**
     * @test
     *
     * @dataProvider provide_data_for_supports_denormalization
     */
    public function supports_denormalization(mixed $data, string $type, bool $expected): void
    {
        $sut = new TimeNormalizer();

        $actual = $sut->supportsDenormalization($data, $type);

        $this->assertEquals($expected, $actual);
    }

    public static function provide_data_for_supports_denormalization(): array
    {
        return [
            'valid' => ['data' => '2021-09-01T00:00:00Z', 'type' => Time::class, 'expected' => true],
            'different_type' => ['data' => '2021-09-01T00:00:00Z', 'type' => 'string', 'expected' => false],
            'different_data' => ['data' => 123, 'type' => Time::class, 'expected' => false],
        ];
    }

    /** @test */
    public function get_supported_types(): void
    {
        $sut = new TimeNormalizer();

        $actual = $sut->getSupportedTypes(null);

        $this->assertEquals([Time::class => true], $actual);
    }
}
