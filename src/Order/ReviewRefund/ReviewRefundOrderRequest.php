<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\ReviewRefund;

use Imdhemy\GooglePlay\Order\Model\ConsumptionUsageEvent;
use Imdhemy\GooglePlay\Order\Model\RefundPreference;
use InvalidArgumentException;
use Symfony\Component\Serializer\Attribute as Serialization;

final readonly class ReviewRefundOrderRequest
{
    private const int MAX_CONSUMPTION_PERCENTAGE_MILLIUNITS = 100_000;
    private const int MAX_CONSUMPTION_USAGE_EVENTS = 1_000;

    /**
     * @param string                           $packageName                     The package name of the application,
     *                                                                          for example 'com.some.thing'
     * @param string                           $orderId                         The order ID provided to the user when
     *                                                                          the order was purchased
     * @param string                           $pendingRefundToken              The token from the pending refund
     *                                                                          review notification
     * @param bool                             $sampleContentProvided           Whether a free sample, trial, or
     *                                                                          feature information was provided before
     *                                                                          purchase
     * @param RefundPreference                 $refundPreference                The developer's preference on whether
     *                                                                          Google Play should grant the refund
     * @param int|null                         $consumptionPercentageMilliunits Consumed percentage in milliunits
     *                                                                          (0–100,000), for example 45200 for
     *                                                                          45.2%
     * @param list<ConsumptionUsageEvent>|null $consumptionUsageEvents          At most 1,000 consumption usage events
     */
    public function __construct(
        #[Serialization\Ignore]
        public string $packageName,
        #[Serialization\Ignore]
        public string $orderId,
        public string $pendingRefundToken,
        public bool $sampleContentProvided,
        public RefundPreference $refundPreference,
        public ?int $consumptionPercentageMilliunits = null,
        public ?array $consumptionUsageEvents = null,
    ) {
        if (null !== $consumptionPercentageMilliunits
            && ($consumptionPercentageMilliunits < 0 || $consumptionPercentageMilliunits > self::MAX_CONSUMPTION_PERCENTAGE_MILLIUNITS)
        ) {
            throw new InvalidArgumentException(sprintf('The consumption percentage must be between 0 and %d milliunits.', self::MAX_CONSUMPTION_PERCENTAGE_MILLIUNITS));
        }

        if (null !== $consumptionUsageEvents && count($consumptionUsageEvents) > self::MAX_CONSUMPTION_USAGE_EVENTS) {
            throw new InvalidArgumentException(sprintf('At most %d consumption usage events are allowed.', self::MAX_CONSUMPTION_USAGE_EVENTS));
        }
    }
}
