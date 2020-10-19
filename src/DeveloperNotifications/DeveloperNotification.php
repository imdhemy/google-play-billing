<?php


namespace Imdhemy\GooglePlay\DeveloperNotifications;

class DeveloperNotification
{
    public const ONE_TIME_PRODUCT_NOTIFICATION = 'oneTimeProductNotification';
    public const SUBSCRIPTION_NOTIFICATION = 'subscriptionNotification';
    public const TEST_NOTIFICATION = 'testNotification';

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $packageName;

    /**
     * @var int
     */
    protected $eventTimeMillis;

    /**
     * @var array|null
     */
    protected $oneTimeProductNotification;

    /**
     * @var array|null
     */
    protected $subscriptionNotification;

    /**
     * @var array|null
     */
    protected $testNotification;

    /**
     * DeveloperNotification constructor.
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array|null $oneTimeProductNotification
     * @param array|null $subscriptionNotification
     * @param array|null $testNotification
     */
    public function __construct(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        ?array $oneTimeProductNotification = null,
        ?array $subscriptionNotification = null,
        ?array $testNotification = null
    ) {
        $this->version = $version;
        $this->packageName = $packageName;
        $this->eventTimeMillis = $eventTimeMillis;
        $this->oneTimeProductNotification = $oneTimeProductNotification;
        $this->subscriptionNotification = $subscriptionNotification;
        $this->testNotification = $testNotification;
    }

    /**
     * @param string $data
     * @return self
     */
    public static function parse(string $data): self
    {
        $decodedData = json_decode(base64_decode($data), true);
        $params = array_values($decodedData);

        if (isset($decodedData[self::ONE_TIME_PRODUCT_NOTIFICATION])) {
            return self::oneTimeProductNotification(...$params);
        }

        if (isset($decodedData[self::SUBSCRIPTION_NOTIFICATION])) {
            return self::subscriptionNotification(...$params);
        }

        return self::testNotification(...$params);
    }

    /**
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array $oneTimeProductNotification
     * @return static
     */
    protected static function oneTimeProductNotification(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        array $oneTimeProductNotification
    ): self {
        return new self($version, $packageName, $eventTimeMillis, $oneTimeProductNotification);
    }

    /**
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array $subscriptionNotification
     * @return static
     */
    protected static function subscriptionNotification(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        array $subscriptionNotification
    ): self {
        return new self($version, $packageName, $eventTimeMillis, null, $subscriptionNotification);
    }

    /**
     * @param string $version
     * @param string $packageName
     * @param int $eventTimeMillis
     * @param array $testNotification
     * @return static
     */
    protected static function testNotification(
        string $version,
        string $packageName,
        int $eventTimeMillis,
        array $testNotification
    ): self {
        return new self($version, $packageName, $eventTimeMillis, null, null, $testNotification);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        if (! is_null($this->oneTimeProductNotification)) {
            return self::ONE_TIME_PRODUCT_NOTIFICATION;
        }

        if (! is_null($this->subscriptionNotification)) {
            return self::SUBSCRIPTION_NOTIFICATION;
        }

        return self::TEST_NOTIFICATION;
    }

    /**
     * @return SubscriptionNotification
     */
    public function getSubscriptionNotification(): SubscriptionNotification
    {
        $params = [
            $this->version,
            $this->packageName,
            $this->eventTimeMillis,
            $this->subscriptionNotification['purchaseToken'],
            $this->subscriptionNotification['subscriptionId'],
        ];

        return new SubscriptionNotification(...$params);
    }

    /**
     * @return OneTimePurchaseNotification
     */
    public function getOneTimeProductNotification(): OneTimePurchaseNotification
    {
        return new OneTimePurchaseNotification(
            $this->version,
            $this->oneTimeProductNotification['notificationType'],
            $this->oneTimeProductNotification['purchaseToken'],
            $this->oneTimeProductNotification['sku']
        );
    }

    /**
     * @return array|null
     */
    public function getTestNotification(): ?array
    {
        return $this->testNotification;
    }
}
