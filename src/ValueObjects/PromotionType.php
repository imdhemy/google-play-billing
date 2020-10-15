<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class PromotionType
{
    /**
     * @var int|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $promotionCode;

    /**
     * PromotionType constructor.
     * @param int|null $type
     * @param string|null $promotionCode
     */
    public function __construct(?int $type = null, ?string $promotionCode = null)
    {
        $this->type = $type;
        $this->promotionCode = $promotionCode;
    }

    /**
     * @return bool
     */
    public function isOneTimeCode(): bool
    {
        return $this->type === 0;
    }

    /**
     * @return bool
     */
    public function isVanityCode(): bool
    {
        return $this->type === 1;
    }

    /**
     * @return string|null
     */
    public function getPromotionCode(): ?string
    {
        return $this->promotionCode;
    }

    /**
     * @return bool
     */
    public function hasPromotionCode(): bool
    {
        return ! is_null($this->type);
    }
}
