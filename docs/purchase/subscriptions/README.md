# Subscription lifecycle

This document describes how to process subscriptions in your backend. You can find more information about the cycle in
the [official documentation](https://developer.android.com/google/play/billing/lifecycle/subscriptions).

## Subscription Service Instantiation

To process subscriptions, you need to instantiate the `SubscriptionService` class. Below you can find how to do it:

```php
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionState;
use Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;

$client = ClientFactory::create();
$normalizer = Normalizer::create();
$serializer = Serializer::create();

$subscriptionService = new SubscriptionService($client, $normalizer, $serializer);
```

## New auto-renewing subscription purchases

When a user purchases a subscription, a message with type

is sent to your RTDN client. You can know that a user has purchased a subscription through multiple ways:

1. The Real-time Developer Notifications (RTDN) message [
   `SubscriptionNotification`](https://developer.android.com/google/play/billing/rtdn-reference#sub) with type
   [
   `SUBSCRIPTION_PURCHASED`](https://github.com/imdhemy/google-play-billing/blob/77655a51d2e778e161c6c475da0a7b752df32a8e/src/Domain/Rtdn/Type/SubscriptionNotificationType.php#L12)
   is sent to your RTDN client.
2. In your android app, through
   the [PurchasesUpdatedListener](https://developer.android.com/reference/com/android/billingclient/api/PurchasesUpdatedListener).
3. Manually [fetching purchases](https://developer.android.com/google/play/billing/integrate#fetch) in your app's
   `onResume()` method

Nevertheless, you should process the new purchase in your secure backend. To do this, follow these steps:

### Query the subscription purchase endpoint

> [!TIP]
> The following example shows how to implement
> the [steps provided by Google](https://developer.android.com/google/play/billing/lifecycle/subscriptions#new-auto) in
> their documentation.

First, you need to [instantiate the SubscriptionService](#subscription-service-instantiation), then you can query the
subscription purchase endpoint as follows:

```php
$subscriptionService = new SubscriptionService($client, $normalizer, $serializer);

// Get Subscription Purchase V2
$subscriptionPurchase = $subscriptionService->get($packageName, $purchaseToken);

// Verify subscription state is active
if(SubscriptionState::ACTIVE !== $subscriptionPurchase->subscriptionState){
    throw new \RuntimeException('Subscription is not active');
}

// Identify the user account associated with the subscription
$accountId = $subscriptionPurchase->externalAccountIdentifiers->obfuscatedExternalAccountId;

// Give the user access to the content
// ...
```

> ![NOTE]
> If you don't acknowledge a new subscription purchase within three days, the user automatically receives a refund, and
> Google Play revokes the purchase.

To ensure that the subscription is acknowledged, you can use the `acknowledge` method:

```php
$subscriptionService = new SubscriptionService($client, $normalizer, $serializer);

// This method is not supported on SubscriptionPurchase V2 yet.
$subscriptionService->legacyAcknowledge(string $packageName, string $token, string $developerPayload);
```
