<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CanceledStateContext;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\DeveloperInitiatedCancellation;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ReplacementCancellation;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SystemInitiatedCancellation;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\UserInitiatedCancellation;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CanceledStateContextTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function system_initiated_cancellation(): void
    {
        $data = ['systemInitiatedCancellation' => []];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(SystemInitiatedCancellation::class, $actual->systemInitiatedCancellation);
    }

    #[Test]
    public function developer_initiated_cancellation(): void
    {
        $data = ['developerInitiatedCancellation' => []];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(DeveloperInitiatedCancellation::class, $actual->developerInitiatedCancellation);
    }

    #[Test]
    public function replacement_cancellation(): void
    {
        $data = ['replacementCancellation' => []];

        $actual = $this->normalizer->normalize($data, CanceledStateContext::class);

        $this->assertInstanceOf(ReplacementCancellation::class, $actual->replacementCancellation);
    }
}
