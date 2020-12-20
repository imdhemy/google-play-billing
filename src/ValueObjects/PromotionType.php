<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class PromotionType
{
    const TYPE_ONE_TIME_CODE = 0;
    const TYPE_VANITY_CODE = 1;
    const PROMOTION_CODE_LENGTH = 5;

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
     * @param int $length
     * @return static
     */
    public static function generatePromotionCode(int $length = 0): string
    {
        $length = $length > 0 ? $length : self::PROMOTION_CODE_LENGTH;
        $code = '';

        while ($length > 0) {
            $code .= self::getRandomChar();
            $length--;
        }

        return $code;
    }

    /**
     * @return string
     */
    protected static function getRandomChar(): string
    {
        $charList = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));

        return $charList[array_rand($charList)];
    }

    /**
     * @return bool
     */
    public function isOneTimeCode(): bool
    {
        return $this->type === self::TYPE_ONE_TIME_CODE;
    }

    /**
     * @return bool
     */
    public function isVanityCode(): bool
    {
        return $this->type === self::TYPE_VANITY_CODE;
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

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @return static
     */
    public static function fake(): self
    {
        $type = mt_rand(self::TYPE_ONE_TIME_CODE, self::TYPE_VANITY_CODE);
        $promotionCode = self::generatePromotionCode();

        return new self($type, $promotionCode);
    }
}
