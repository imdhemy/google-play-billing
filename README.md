# PHP Google Play Billing

**PHP Google Play Billing** provides the required implementation to add Google Play's billing system to your php project.

## 1.Google Play's billing system overview

Google Play's billing system is a service that enables you to sell digital products and content in your Android app.

You can use Google Play's billing system to sell the following types of digital content:

* One-time products: A one-time product is content that users can purchase with a single, non-recurring charge to the user's form of payment.
  One-time products can be either consumable or non-consumable:
  
    * A consumable product is one that a user consumes to receive in-app content, such as in-game currency. When a user consumes the product, your app dispenses the associated content, and the user can
      then purchase the item again.
    * A non-consumable product is a product that is purchased only once to provide a permanent benefit. Examples include premium upgrades and level packs.
    
* Subscriptions: Subscriptions: A subscription is a product that provides access to content on a recurring basis. Subscriptions renew automatically until they're canceled. Examples of subscriptions include access to online magazines and music streaming services.

## 2.Sell subscriptions
This section describes how to handle subscription lifecycle events, such as renewals and expiration.

### 2.1 Life of a purchase
Here's a typical purchase flow for a one-time purchase or a subscription.
* Show the user what they can buy.
* Launch the purchase flow for the user to accept the purchase.
* Verify the purchase on your server.
* Give content to the user, and acknowledge delivery of the content. Optionally, mark the item as consumed so that the user can buy the item again.
 
Subscriptions automatically renew until they are canceled. A subscription can go through the following states:

* Active: User is in good standing and has access to the subscription.
* Cancelled: User has cancelled but still has access until expiration.
* In grace period: User experienced a payment issue, but still has access while Google is retrying the payment method.
* On hold: User experienced a payment issue, and no longer has access while Google is retrying the payment method.
* Paused: User paused their access, and does not have access until they resume.
* Expired: User has cancelled and lost access to the subscription. The user is considered churned at expiration.

### 2.2 Handling the subscription lifecycle
A subscription can go through various state changes throughout its [lifecycle](/path/to/lifecycle) and your app needs
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

Your app should listen for state changes using [Real-time developer notifications](https://developer.android.com/google/play/billing/getting-ready#configure-rtdn) to ensure state is kept in-sync. A SubscriptionNotification is sent for events affecting subscription state such as renewals and cancellations. You need to call the developer API after receiving a Real-time developer notifications to get the complete status and update your own backend state. These notifications tell you only that the subscription state changed. They do not give you complete information about overall subscription status.

> Note: Due to quota restrictions, it is not recommended to check state by polling the Google Play Developer API at regular intervals instead of leveraging Real-time developer notifications.

Your app needs to handle the state changes that are described in the following table:

| State | Notification |
| --- | ---|
| New subscriptions | SUBSCRIPTION_PURCHASED |
| Renewals | SUBSCRIPTION_RENEWED| 
| Expiration | SUBSCRIPTION_EXPIRED|
| Cancellations | SUBSCRIPTION_CANCELLED |
| Revocations | SUBSCRIPTION_REVOKED |
| Account hold | ... |
| Grace period | SUBSCRIPTION_IN_GRACE_PERIOD |
| Paused subscriptions | ... |
| Restorations | ... |
| Upgrades, downgrades, and re-sign-ups | ... |

