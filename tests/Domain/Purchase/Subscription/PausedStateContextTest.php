<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\PausedStateContext;
use Tests\TestCase;

final class PausedStateContextTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $data = ['autoResumeTime' => '2014-10-02T15:01:23Z'];

        $actual = $this->normalizer->normalize($data, PausedStateContext::class);

        $this->assertInstanceOf(PausedStateContext::class, $actual);
        $this->assertEquals($data['autoResumeTime'], $actual->autoResumeTime->originalValue);
    }
}
