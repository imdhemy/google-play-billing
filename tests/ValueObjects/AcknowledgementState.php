<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

enum AcknowledgementState: string
{
    case UNSPECIFIED = 'ACKNOWLEDGEMENT_STATE_UNSPECIFIED';
    case PENDING = 'ACKNOWLEDGEMENT_STATE_PENDING';
    case ACKNOWLEDGED = 'ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED';
}
