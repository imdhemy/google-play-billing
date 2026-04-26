<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Provider\Base;

final class GoogleAuthProvider extends Base
{
    public function googleCredentials(): array
    {
        return [
            'type' => 'service_account',
            'project_id' => 'project-id-123456',
            'private_key_id' => '0123456789abcdef0123456789abcdef01234567',
            'private_key' => "[REDACTED PRIVATE KEY]\n",
            'client_email' => 'fake@project-id-123456.iam.gserviceaccount.com',
            'client_id' => '012345678901234567890',
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/fake%40project-id-123456.iam.gserviceaccount.com',
        ];
    }
}
