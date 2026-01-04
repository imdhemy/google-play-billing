<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\RegionsVersion;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RegionsVersionTest extends TestCase
{
    #[test]
    public function instantiate(): void
    {
        $data = [
            'version' => 'v1.2.3',
        ];

        $regionsVersion = $this->normalizer->normalize($data, RegionsVersion::class);

        $this->assertEquals($data['version'], $regionsVersion->version);
    }
}
