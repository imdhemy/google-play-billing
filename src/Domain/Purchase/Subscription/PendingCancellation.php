<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * This type has no fields.
 * This is an indicator of whether there is a pending cancellation on the virtual installment plan. The cancellation
 * will happen only after the user finished all committed payments.
 *
 * @see      https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#pendingcancellation
 */
final class PendingCancellation
{
}
