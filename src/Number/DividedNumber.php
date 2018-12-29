<?php

namespace Sfadless\NumberToStringConverter\Number;

use Sfadless\NumberToStringConverter\Exception\InvalidDigitException;

/**
 * DividedNumber
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class DividedNumber implements \Countable
{
    /**
     * @var int[]
     */
    private $digits = [];

    /**
     * @param $digit int
     * @return $this
     */
    public function addDigit($digit)
    {
        $digit = (int) $digit;

        if ($digit < 0 || $digit >= 1000) {
            throw new InvalidDigitException(sprintf("Digit should be greater or equal 0 and less than 1000, %d given", $digit));
        }

        $this->digits[] = $digit;

        return $this;
    }

    /**
     * @return array
     */
    public function getDigits()
    {
        return $this->digits;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->digits);
    }
}