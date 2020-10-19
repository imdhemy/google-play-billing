# PHP Google Play Billing
[![Latest Version on Packagist](https://img.shields.io/packagist/v/imdhemy/google-play-billing.svg?style=flat-square)](https://packagist.org/packages/imdhemy/google-play-billing)
[![Total Downloads](https://img.shields.io/packagist/dt/imdhemy/google-play-billing.svg?style=flat-square)](https://packagist.org/packages/imdhemy/google-play-billing)

**PHP Google Play Billing** provides the required implementation to add Google Play's billing system to your php project.

## Google Play's billing system overview

Google Play's billing system is a service that enables you to sell digital products and content in your Android app.

You can use Google Play's billing system to sell the following types of digital content:

* **One-time products**: A one-time product is content that users can purchase with a single, non-recurring charge to
 the user's form of payment.
  One-time products can be either consumable or non-consumable:
  
    * _A consumable product_ is one that a user consumes to receive in-app content, such as in-game currency. When a
     user consumes the product, your app dispenses the associated content, and the user can
      then purchase the item again.
    * _A non-consumable product_ is a product that is purchased only once to provide a permanent benefit. Examples
     include premium upgrades and level packs.
        
* **Subscriptions**: A subscription is a product that provides access to content on a recurring basis
. Subscriptions renew automatically until they're canceled. Examples of subscriptions include access to online magazines and music streaming services.

## Installation
Install the package via composer:

```
composer require imdhemy/google-play-billing
```

## Configuration
Requests to the Google Play Developer API, requires authentication and scopes. To authenticate your machine create a
 service account, then set the environment variable `GOOGLE_APPLICATION_CREDENTIALS`
 
 1. In the Cloud Console, go to the [Create service account](https://console.cloud.google.com/apis/credentials/serviceaccountkey?_ga=2.92610013.131807880.1603050486-1132570079.1602633482) key page.
 2. From the **Service account** list, select **New service account**.
 3. In the **Service account name** field, enter a name.
 4. From the **Role** list, select **Project** > **Owner**.
 5. Click **Create**. A JSON file that contains your key downloads to your computer.
 6. You can set the environment variable by:
 
```php
$path = 'path/to/google-app-credentials.json';
putenv(sprintf("GOOGLE_APPLICATION_CREDENTIALS=%s", $path));
```

## Sell products
With any type of your products, you can use the REST api to: 
1. **acknowledge**: Acknowledges a purchase of an inapp item.
2. **get**: Checks the purchase and consumption status of an inapp item.

### Acknowledge a product
To acknowledge a product, you need a Client, which can be created by `ClientFactory` using the android publisher scope
, then create an instance of the `Imdhemy\Products\Product` class, finally trigger the `acknowledge()` method.

```php
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Products\Product;

$client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
$product = new Product($client, 'com.example.package.name', 'productId', 'Purchase_Token');
$product->acknowledge();
```

### Get the consumption state of a product
To check the purchase and consumption status of an inapp item, use the same steps used to acknowledge a product
, but trigger the `get()` method not the acknowledge one.

```php
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Products\Product;

$client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
$product = new Product($client, 'com.example.package.name', 'productId', 'Purchase_Token');
$resource = $product->get();
```

The get() method returns a `Imdhemy\GooglePlay\Products\ProductPurchase` object, which contains the following methods:

| Method | Description|
| --- | --- |
| getKind | ...|
| getPurchaseTime | ... |
| getPurchaseState | ... |
| getConsumptionState | ... |
| getDeveloperPayload | ... |
| getOrderId | ... | 
| getAcknowledgementState | ... |
| getPurchaseToken | ... |
| getProductId | ... |
| getQuantity | ... |
| getObfuscatedExternalAccountId | ... |
| getObfuscatedExternalProfileId | ... |
| getRegionCode | ... |


## Sell subscriptions
This section describes how to handle subscription lifecycle events, such as renewals and expiration.

### Life of a purchase
Here's a typical purchase flow for a one-time purchase or a subscription.
* Show the user what they can buy.
* Launch the purchase flow for the user to accept the purchase.
* Verify the purchase on your server.
* Give content to the user, and acknowledge delivery of the content. Optionally, mark the item as consumed so that the user can buy the item again.
 
Subscriptions automatically renew until they are canceled. A subscription can go through the following states:

* **Active**: User is in good standing and has access to the subscription.
* **Cancelled**: User has cancelled but still has access until expiration.
* **In grace period**: User experienced a payment issue, but still has access while Google is retrying the payment
 method.
* **On hold**: User experienced a payment issue, and no longer has access while Google is retrying the payment method.
* **Paused**: User paused their access, and does not have access until they resume.
* **Expired**: User has cancelled and lost access to the subscription. The user is considered churned at expiration.

### Handling the subscription lifecycle
A subscription can go through various state changes throughout its [lifecycle](#life-of-a-purchase) and your app needs
 to respond to each change
. To check the subscriber's state, your app can query using the Purchases.subscriptions:get (provided by this package) in the Google Play Developer API.

| State | Is returned | expiryTimeMillis | paymentState | autoRenewing |
| --- | --- | --- | --- | --- |
| Active | Yes | Future | 1 (Payment Received) | True |
| Cancelled | Yes | Future | 1 (Payment Received) | False |
| In grace period | Yes | Future | 0 (Payment Pending) | True |
| On hold | Yes | Past | 0 (Payment Pending) | True |
| Paused | Yes | Past | 1 (Payment Received) | True |
| Expired | Yes | Past | 1 (Payment Received)| False |

The following methods are available to be used on a subscription:
1. acknowledge: Acknowledges a subscription purchase.
2. get: Checks whether a user's subscription purchase is valid and returns its expiry time.
3. ~~cancel~~: Cancels a user's subscription purchase.
4. ~~defer~~: Defers a user's subscription purchase until a specified future expiration time.
5. ~~refund~~: Refunds a user's subscription purchase, but the subscription remains valid until its expiration time and it will continue to recur.
6. ~~revoke~~: Refunds and immediately revokes a user's subscription purchase.

**N.B.** The stroked method are not implemented yet. help us with your contributions 😅. 

```php
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Subscriptions\Subscription;

$client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
$subscription = new Subscription($client, 'com.example.package.name', 'subscriptionId', 'Purchase_Token');
$subscription->acknowledge();
$resource = $subscription->get(); // Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase
```

The Following methods are available in `Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase` Object

| Method | Description |
| --- | --- |
| getKind | ... |
| isAutoRenewing | ... |
| getPriceCurrencyCode | ... |
| getPriceAmountMicros | ... |
| getCountryCode | ... |
| getDeveloperPayload | ... |
| getOrderId | ... |
| getLinkedPurchaseToken | ... |
| getEmailAddress | ... |
| getGivenName | ... |
| getProfileId | ... |
| getExternalAccountId | ... |
| getObfuscatedExternalAccountId | ... |
| getObfuscatedExternalProfileId | ... |
| getStartTime | ... |
| getExpiryTime | ... |
| getAutoResumeTime | ... |
| getIntroductoryPriceInfo | ... |
| getPriceChange | ... |
| getCancellation | ... |
| getPromotionType | ... |
| getAcknowledgementState | ... |


Your app should listen for state changes using [Real-time developer notifications](https://developer.android.com/google/play/billing/getting-ready#configure-rtdn) to ensure state is kept in-sync. A SubscriptionNotification is sent for events affecting subscription state such as renewals and cancellations. You need to call the developer API after receiving a Real-time developer notifications to get the complete status and update your own backend state. These notifications tell you only that the subscription state changed. They do not give you complete information about overall subscription status.

> Note: Due to quota restrictions, it is not recommended to check state by polling the Google Play Developer API at regular intervals instead of leveraging Real-time developer notifications.

Your app needs to handle the state changes that are described in the following table:

| State | Notification | Value |
| --- | ---| --- |
| New subscriptions | SUBSCRIPTION_PURCHASED | 4 |
| Renewals | SUBSCRIPTION_RENEWED | 2 |
| Expiration | SUBSCRIPTION_EXPIRED | 13|
| Cancellations | SUBSCRIPTION_CANCELLED | |
| Revocations | SUBSCRIPTION_REVOKED | 3 |
| Account hold | SUBSCRIPTION_ON_HOLD | 5 |
| Grace period | SUBSCRIPTION_IN_GRACE_PERIOD | 6 |
| Paused subscriptions | SUBSCRIPTION_PAUSED | 10 |
| Restorations | ... | ... |
| Upgrades, downgrades, and re-sign-ups | ... | ... |

After receiving a real-time developer notification, you can parse its contents as follows:
```php
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
$data = 'the_received_base_64_encoded_string';
$developerNotification = DeveloperNotification::parse($data); // Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification
$subscriptionNotification = $developerNotification->getSubscriptionNotification(); // Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification
```

The Following methods are available in 
`Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification`

| Method | Description |
| --- | --- |
| parse | ... |
| getType | ... |
| getVersion| ... |
| getPackageName | ... |
| getEventTime | ... |
| getSubscriptionNotification | ... |
| getOneTimeProductNotification | ... |
| getTestNotification | ... |

The Following methods are available in 
`Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification`

| Method | Description |
| --- | --- |
| getVersion | ... |
| getNotificationType | ... |
| getPurchaseToken | ... |
| getSubscriptionId | ... |
