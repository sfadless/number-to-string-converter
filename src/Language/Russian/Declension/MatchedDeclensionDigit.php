<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Declension;

/**
 * MatchedDeclensionDigit
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class MatchedDeclensionDigit
{
    /**
     * @var int
     */
    private $digit;

    /**
     * @var string
     */
    private $digitString;

    /**
     * @var string
     */
    private $declension;

    /**
     * MatchedDeclensionDigit constructor.
     * @param int $digit
     * @param string $digitString
     * @param string $declension
     */
    public function __construct($digit, $digitString, $declension = '')
    {
        $this->digit = $digit;
        $this->digitString = $digitString;
        $this->declension = $declension;
    }

    /**
     * @return int
     */
    public function getDigit()
    {
        return $this->digit;
    }

    /**
     * @return string
     */
    public function getDigitString()
    {
        return $this->digitString;
    }

    /**
     * @return string
     */
    public function getDeclension()
    {
        return $this->declension;
    }
}