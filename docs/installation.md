# Installation

Install the package via composer:

```
composer require imdhemy/google-play-billing
```

## Configuration

Requests to the Google Play Developer API requires authentication key. To authenticate your machine create a service
account,
the [set the environment variable](./creating-a-client.md#set-the-environment-variable) `GOOGLE_APPLICATION_CREDENTIALS`
to the path of the downloaded json key. This allows you to create an authenticated client, or alternatively you
can [pass the contents of the downloaded key](./creating-a-client.md#create-from-json-key-array) as an associative
array. You can find more information on [creating a client documentation](./creating-a-client.md).

## How to download the Google application credentials file:

1. In the Cloud Console, go
   the [Create Service Account](https://console.cloud.google.com/apis/credentials/serviceaccountkey?_ga=2.92610013.131807880.1603050486-1132570079.1602633482)
   page.
2. From the **Service account** list, select **New service account**.
3. In the **Service account name** field, enter a name.
4. From the **Role** list, select **Project > Owner**.
5. Click **Create**. A JSON file that contains your key downloads to your computer.
