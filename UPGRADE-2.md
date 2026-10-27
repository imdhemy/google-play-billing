# Upgrade From 1.x to 2.0

## Clients

### Client Factories

**Likelihood Of Impact: Medium**

Replace `Imdhemy\GooglePlay\ClientFactory` with
`Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory`.

### Purchase Clients

**Likelihood Of Impact: High**

Replace the product and subscription clients with the corresponding services:

| Old client                                            | Replacement                                              |
|-------------------------------------------------------|----------------------------------------------------------|
| `Imdhemy\GooglePlay\Products\ProductClient`           | `Imdhemy\GooglePlay\Domain\Purchase\ProductService`      |
| `Imdhemy\GooglePlay\Subscriptions\SubscriptionClient` | `Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService` |

The services use different method signatures and response objects; changing the
imports alone is not sufficient. For legacy subscription deferral, use
`SubscriptionService::legacyDefer()` and read the response's `$newExpiryAt` property
instead of using the `Time` returned by `SubscriptionClient::defer()`.

## Developer Notifications

### Notification Classes

**Likelihood Of Impact: High**

Migrate classes from the `Imdhemy\GooglePlay\DeveloperNotifications` namespace to
the corresponding classes under `Imdhemy\GooglePlay\Domain\Rtdn`. Update notification
handling to use the replacement objects and their public properties.

## Dates

### Time Value Object

**Likelihood Of Impact: Medium**

`Imdhemy\GooglePlay\ValueObjects\Time`, the accessors returning it, and the public
properties containing it have been removed.
Use the `DateTimeImmutable` replacements below. Class names in the tables are
relative to `Imdhemy\GooglePlay`.

| Class                                          | Old accessor                | Replacement            |
|------------------------------------------------|-----------------------------|------------------------|
| `Products\ProductPurchase`                     | `getPurchaseTime()`         | `getPurchasedAt()`     |
| `Subscriptions\SubscriptionPurchase`           | `getStartTime()`            | `getStartedAt()`       |
| `Subscriptions\SubscriptionPurchase`           | `getExpiryTime()`           | `getExpiresAt()`       |
| `Subscriptions\SubscriptionPurchase`           | `getAutoResumeTime()`       | `getAutoResumesAt()`   |
| `ValueObjects\Cancellation`                    | `getUserCancellationTime()` | `getUserCancelledAt()` |
| `DeveloperNotifications\DeveloperNotification` | `getEventTime()`            | `getOccurredAt()`      |

| Class                                                             | Old property                  | Replacement              |
|-------------------------------------------------------------------|-------------------------------|--------------------------|
| `Domain\Purchase\Entity\ProductPurchase`                          | `$purchaseTimeMillis`         | `$purchasedAt`           |
| `Domain\Purchase\Entity\SubscriptionPurchase`                     | `$startTime`                  | `$startedAt`             |
| `Domain\Purchase\Subscription\SubscriptionPurchaseLineItem`       | `$expiryTime`                 | `$expiresAt`             |
| `Domain\Purchase\Subscription\PausedStateContext`                 | `$autoResumeTime`             | `$autoResumesAt`         |
| `Domain\Purchase\Subscription\PrepaidPlan`                        | `$allowExtendAfterTime`       | `$extensionAllowedAfter` |
| `Domain\Purchase\Subscription\SubscriptionItemPriceChangeDetails` | `$expectedNewPriceChargeTime` | `$expectedPriceChangeAt` |
| `Domain\Purchase\Subscription\UserInitiatedCancellation`          | `$cancelTime`                 | `$canceledAt`            |
| `Domain\Rtdn\Notification\DeveloperNotification`                  | `$eventTimeMillis`            | `$occurredAt`            |
| `Dto\DeferSubscriptionResponse`                                   | `$newExpiryTimeMillis`        | `$newExpiryAt`           |

The replacements preserve nullability, millisecond precision, and RFC 3339 offsets,
with fractional precision limited to microseconds. Millisecond timestamps use UTC.

```php
// Before
$expiresAt = $lineItem->expiryTime?->carbon;

// After
$expiresAt = $lineItem->expiresAt;
```

Replace access to `carbon`, `getCarbon()`, or `toDateTime()` with the replacement
date API.
