<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * A single event of content consumption by the purchaser.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders/reviewrefund#consumptionusageevent
 */
final readonly class ConsumptionUsageEvent
{
    /**
     * @param string|null         $obfuscatedAccountId        Identifies the purchaser's account in the app
     * @param string|null         $obfuscatedProfileId        Identifies the purchaser's profile in the app
     * @param string|null         $consumptionTime            RFC 3339 timestamp, for example "2014-10-02T15:01:23Z"
     * @param string|null         $ipAddress                  IP address where the consumption occurred
     * @param string|null         $consumptionItemDescription Free-form description, at most 5000 characters
     * @param CoarseLocation|null $location                   Coarse location where the consumption occurred
     */
    public function __construct(
        public ?string $obfuscatedAccountId = null,
        public ?string $obfuscatedProfileId = null,
        public ?string $consumptionTime = null,
        public ?string $ipAddress = null,
        public ?string $consumptionItemDescription = null,
        public ?CoarseLocation $location = null,
    ) {
    }
}
