<?php


namespace Imdhemy\GooglePlay\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $path = realpath(__DIR__ . '/../google-app-credentials.json');
        putenv(sprintf("GOOGLE_APPLICATION_CREDENTIALS=%s", $path));
    }
}
