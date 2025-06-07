<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\CanceledStateContext;
use Imdhemy\GooglePlay\ValueObjects\DeveloperInitiatedCancellation;
use Imdhemy\GooglePlay\ValueObjects\ReplacementCancellation;
use Imdhemy\GooglePlay\ValueObjects\SystemInitiatedCancellation;
use Imdhemy\GooglePlay\ValueObjects\UserInitiatedCancellation;
use Tests\TestCase;

final class CanceledStateContextTest extends TestCase
{
    /** @test */
    public function user_instantiated_cancellation(): void
    {
        $cancelTime = '2014-10-02T15:01:23.045123456Z';
        $data = [
            'userInitiatedCancellation' => [
                'cancelSurveyResult' => [
                    'reason' => 'CANCEL_SURVEY_REASON_UNSPECIFIED',
                ],
                'cancelTime' => $cancelTime,
            ],
        ];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(UserInitiatedCancellation::class, $actual->userInitiatedCancellation);
        $this->assertSame($cancelTime, $actual->userInitiatedCancellation->cancelTime->originalValue);
    }

    /** @test */
    public function system_initiated_cancellation(): void
    {
        $data = ['systemInitiatedCancellation' => []];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(SystemInitiatedCancellation::class, $actual->systemInitiatedCancellation);
    }

    /** @test */
    public function developer_initiated_cancellation(): void
    {
        $data = ['developerInitiatedCancellation' => []];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(DeveloperInitiatedCancellation::class, $actual->developerInitiatedCancellation);
    }

    /** @test */
    public function replacement_cancellation(): void
    {
        $data = ['replacementCancellation' => []];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(ReplacementCancellation::class, $actual->replacementCancellation);
    }
}
