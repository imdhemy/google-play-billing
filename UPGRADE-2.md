# Upgrade from 1.x to 2.0

- All `Imdhemy\GooglePlay\DeveloperNotifications` namespace classes should be replaced with
  `\Imdhemy\GooglePlay\Domain\Rtdn` namespace classes.
- Replace the usage of `\Imdhemy\GooglePlay\Products\ProductClient` with
  `\Imdhemy\GooglePlay\Domain\Purchase\ProductService`
- Replace the usage of `\Imdhemy\GooglePlay\Subscriptions\SubscriptionClient` with
  `\Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService`
- Replace the usage of `\Imdhemy\GooglePlay\ClientFactory` with `\Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory`

## Dates

### Time Value Object

**Likelihood Of Impact: Medium**

`Imdhemy\GooglePlay\ValueObjects\Time` and the accessors that return it have been removed.
Use the `DateTimeImmutable` replacements below.

| Class                                                         | Old accessor                   | Replacement                  |
|---------------------------------------------------------------|--------------------------------|------------------------------|
| `Products\ProductPurchase`                                    | `getPurchaseTime()`            | `getPurchasedAt()`           |
| `Subscriptions\SubscriptionPurchase`                          | `getStartTime()`               | `getStartedAt()`             |
| `Subscriptions\SubscriptionPurchase`                          | `getExpiryTime()`              | `getExpiresAt()`             |
| `Subscriptions\SubscriptionPurchase`                          | `getAutoResumeTime()`          | `getAutoResumesAt()`         |
| `ValueObjects\Cancellation`                                   | `getUserCancellationTime()`    | `getUserCancelledAt()`       |
| `DeveloperNotifications\DeveloperNotification`                | `getEventTime()`               | `getOccurredAt()`            |
| `Domain\Purchase\Entity\ProductPurchase`                      | `$purchaseTimeMillis`          | `$purchasedAt`               |
| `Domain\Purchase\Entity\SubscriptionPurchase`                 | `$startTime`                   | `$startedAt`                 |
| `Domain\Purchase\Subscription\SubscriptionPurchaseLineItem`   | `$expiryTime`                  | `$expiresAt`                 |
| `Domain\Purchase\Subscription\PausedStateContext`             | `$autoResumeTime`              | `$autoResumesAt`             |
| `Domain\Purchase\Subscription\PrepaidPlan`                    | `$allowExtendAfterTime`        | `$extendAllowedAt`           |
| `Domain\Purchase\Subscription\SubscriptionItemPriceChangeDetails` | `$expectedNewPriceChargeTime` | `$expectedNewPriceChargedAt` |
| `Domain\Purchase\Subscription\UserInitiatedCancellation`      | `$cancelTime`                  | `$canceledAt`                |
| `Domain\Rtdn\Notification\DeveloperNotification`              | `$eventTimeMillis`             | `$occurredAt`                |
| `Dto\DeferSubscriptionResponse`                               | `$newExpiryTimeMillis`         | `$newExpiryAt`               |

The replacements are nullable exactly when the old accessor was. Millisecond timestamps keep their
milliseconds and are in UTC. RFC 3339 timestamps keep their offset and up to microsecond precision;
Google may send nanoseconds, which PHP truncates to microseconds.

`RealTimeDeveloperNotification::getOccurredAt()` is documented with `@method` and only implemented by
`DeveloperNotification`. Custom implementations of the interface should add it before upgrading.

```php
// Before
$expiresAt = $lineItem->expiryTime?->carbon;
$isFuture = $lineItem->expiryTime?->isFuture() ?? false;

// After
$expiresAt = $lineItem->expiresAt;
$formatted = $expiresAt?->format('Y-m-d\TH:i:s.uP');
$isFuture = null !== $expiresAt && $expiresAt > new DateTimeImmutable();
```

Use `<` and `>` instead of `Time::isPast()` and `Time::isFuture()`. Replace `getCarbon()` and
`toDateTime()` with the `DateTimeImmutable` value, or `Carbon::instance($date)` if you still need Carbon.
For dates you construct yourself, `new Time('1603051412791')` becomes
`new DateTimeImmutable('@1603051412.791')`.
