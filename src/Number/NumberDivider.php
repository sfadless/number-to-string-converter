<?php

namespace Sfadless\NumberToStringConverter\Number;

/**
 * NumberDivider
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class NumberDivider
{
    /**
     * @param $number
     *
     * @return DividedNumber
     */
    public function divide($number)
    {
        $dividedNumber = new DividedNumber();

        if ((int) $number < 1000) {
            return $dividedNumber->addDigit($number);
        }

        $numberString = (string) $number;
        $len = strlen($numberString);

        $notFull = $len % 3;

        if ($notFull) {
            $dividedNumber->addDigit(mb_substr($numberString, 0, $notFull));
        }

        for ($i = $notFull; $i < $len; $i += 3) {
            $dividedNumber->addDigit(mb_substr($numberString, $i, 3));
        }

        return $dividedNumber;
    }
}