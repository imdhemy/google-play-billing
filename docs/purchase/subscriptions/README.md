# Subscription lifecycle

This document describes how to process subscriptions in your backend. You can find more information about the cycle in
the [official documentation](https://developer.android.com/google/play/billing/lifecycle/subscriptions).

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

```php
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionState;use Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;

$client = ClientFactory::create();
$normalizer = Normalizer::create();
$serializer = Serializer::create();

// Create a SubscriptionService instance
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
