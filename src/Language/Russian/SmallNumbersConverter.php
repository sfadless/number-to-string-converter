<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

use Sfadless\NumberToStringConverter\Exception\OutOfRangeConvertException;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;

/**
 * SmallNumbersConverter
 *
 * Converts numbers not greater than 999 into strings
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class SmallNumbersConverter
{
    /**
     * @var NumbersCollection
     */
    private $numbersCollection;

    /**
     * SmallNumbersConverter constructor.
     * @param NumbersCollection $numbersCollection
     */
    public function __construct(NumbersCollection $numbersCollection)
    {
        $this->numbersCollection = $numbersCollection;
    }

    /**
     * @param $number int
     * @param string $gender
     * @return string
     */
    public function convert($number, $gender = Declension::GENDER_M)
    {
        if ($number >= 1000 || $number < 0) {
            //TODO exception description
            throw new OutOfRangeConvertException();
        }

        if ($number == 0) {
            return $this->numbersCollection->getUnit(0);
        }

        $converted = [];

        $tens = $number % 100;

        if ($number >= 100) {
            $converted[] = $this->numbersCollection->getHundred($number - $tens);
        }

        if ($tens > 0) {
            $converted = array_merge($converted, $this->convertTens($tens, $gender));
        }

        return implode(" ", $converted);
    }

    /**
     * @param $tens int
     * @param $gender string
     * @return array
     */
    private function convertTens($tens, $gender)
    {
        if ($tens < 10) {
            return [$this->numbersCollection->getUnit($tens, $gender)];
        }

        if ($tens >= 10 && $tens < 20) {
            return [$this->numbersCollection->getTeen($tens)];
        }

        $units = $tens % 10;
        $arTens = [$this->numbersCollection->getTen($tens - $units)];

        if ($units > 0) {
            $arTens[] = $this->numbersCollection->getUnit($units, $gender);
        }

        return $arTens;
    }
}