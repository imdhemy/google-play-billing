# Client

When it comes to consuming an API, the client is a central part. PHP Google Play Billing is using Guzzle clients to
handle requests to the Google Developer API. In this document, I'll show you how to create a client for different use
cases.

## Creating a client

To create a client, use the `ClientFactory` as follows:

```php
use Imdhemy\GooglePlay\ClientFactory;

// Set credentials
$keyPath = 'path/to/google-app-credentials.json';
putenv(sprintf('GOOGLE_APPLICATION_CREDENTIALS=%s', $keyPath));

// Create the client
$client = ClientFactory::create();
```

Check the [configuration section](./installation.md#configuration) to know more about the credentials file.

## Create from credentials array

Sometimes using a global environment key is not enough, suppose you are managing multiple applications with different
accounts. In this case you can pass the contents of the credentials JSON file as an associative array as follows:

```php
use Imdhemy\GooglePlay\ClientFactory;

$credentials = [
    'type' => 'service_account',
    'project_id' => 'project-id-123456',
    'private_key_id' => '0123456789abcdef0123456789abcdef01234567',
    // ... and so on
];
$client = ClientFactory::createWithJsonKey($credentials);
```

## Mocking

During development, you often need to simulate specific scenarios, like returning a valid purchase response, returning
an error, or returning a specific response in a certain condition. You can use the mocking methods to bootstrap your
requests.

The `ClientFactory` provides two methods for this purpose:

### Mocking a single request

To mock a single request you can use the `mock` method by passing the required response as parameter.

```php
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\ClientFactory;

$statusCode = 200;
$headers = [];
$body = 'Hello, World';
 
$expectedResponse = new Response($statusCode, $headers, $body);
$client = ClientFactory::mock($expectedResponse);
```

Whenever you use this client, it will return the specified response.

### Mocking an error

Sometimes you need to mock exception to handle them in your code whenever they happen. For this purpose, you can use
the `mockError` method.

```php
use Imdhemy\GooglePlay\ClientFactory;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

$message = 'Something went wrong';
$error = new RequestException(
          $message,
          new Request('GET', '/admin'),
          new Response(403, [], 'Forbidden')
        );
$client = ClientFactory::mockError($error);
```

### Mocking a queue of responses

If you're going to hit the Google developer API multiple times, you can pass the queue of responses or exceptions as an
array to the `mockQueue` method.

```php
use Imdhemy\GooglePlay\ClientFactory;

$mocks = [$firstResponse, $secondResponse, $error];
$client = ClientFactory::mockQueue($mocks);
```

The mocked responses are returned in order.
