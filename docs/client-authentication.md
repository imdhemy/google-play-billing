# Client Authentication

All requests to the Google Developer API must be authenticated. This package uses (
ADC) [Application Default Credentials](https://cloud.google.com/docs/authentication/application-default-credentials)
to authenticate requests, but you still can use different credentials on the fly if your backend needs to support
multiple Google accounts.

## Credentials File

There are [multiple ways](https://cloud.google.com/docs/authentication/provide-credentials-adc) to generate the
credentials file. Here is a direct guide
on [how to create a service account file](https://cloud.google.com/iam/docs/keys-create-delete?utm_source=chatgpt.com#creating).

## Authentication with Application Default Credentials

You either need to set the
`GOOGLE_APPLICATION_CREDENTIALS` [environment variable](https://cloud.google.com/docs/authentication/application-default-credentials#GAC)
to provide the location of a credential JSON file.

Alternatively, if you're using the `gcloud` CLI and have run `gcloud auth application-default login`, your credentials
will automatically be stored in
a[ well-known location](https://cloud.google.com/docs/authentication/application-default-credentials#personal),
depending on your OS:

- Linux, macOS: `$HOME/.config/gcloud/application_default_credentials.json`
- Windows: `%APPDATA%\gcloud\application_default_credentials.json`

Then you can use the Client factory to create a client instance:

```php
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;

$client = ClientFactory::create();
```

## Authentication with Specific Credentials

In some cases, you may need to use a specific credentials file instead of the default one. You can do this by passing
the decoded credentials array to the client factory:

```php
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;

$credentialsJson = file_get_contents('/path/to/your/credentials.json');
$credentials = json_decode($credentialsJson, true);

$client = ClientFactory::create($credentials);
```

It doesn't matter if you stored the credentials in your filesystem or encrypted them in your database, as long as you
can decode the JSON file into an associative array, you can pass it to the client factory.

## Authenticating multiple Google Accounts

If your backend needs to support multiple Google accounts, you can create multiple client instances with different
credentials.

```php
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;

$credentials1 = $credentialsRepository->findByAccount('account1'); // Fetch credentials for account 1 as an associative array
$client1 = ClientFactory::create($credentials1);

$credentials2 = $credentialsRepository->findByAccount('account2'); // Fetch credentials for account 2 as an associative array
$client2 = ClientFactory::create($credentials2);
```
