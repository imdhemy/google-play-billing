<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Promotion
 * Holds information about the promotion type and code
 */
final class Promotion
{
    public const TYPE_ONE_TIME_CODE = 0;
    public const TYPE_VANITY_CODE = 1;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string|null
     */
    private $code;

    /**
     * @param int $type
     * @param string|null $code
     */
    public function __construct(int $type, ?string $code)
    {
        $this->type = $type;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isVanityCode(): bool
    {
        return $this->type === self::TYPE_VANITY_CODE;
    }

    /**
     * @return bool
     */
    public function isOneTimeCode(): bool
    {
        return $this->type === self::TYPE_ONE_TIME_CODE;
    }
}
