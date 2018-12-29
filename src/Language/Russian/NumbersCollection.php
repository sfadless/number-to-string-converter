<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

use Sfadless\NumberToStringConverter\Exception\FailedReceiveNumberFromCollectionException;
use Sfadless\NumberToStringConverter\Exception\InvalidGenderException;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;

/**
 * NumbersCollection
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class NumbersCollection
{
    /**
     * @var array
     */
    private $units = [
        0 => 'ноль',
        1 => ['m' => 'один', 'f' => 'одна'],
        2 => ['m' => 'два', 'f' => 'две'],
        3 => 'три',
        4 => 'четыре',
        5 => 'пять',
        6 => 'шесть',
        7 => 'семь',
        8 => 'восемь',
        9 => 'девять'
    ];

    /**
     * @var array
     */
    private $teens = [
        10 => 'десять',
        11 => 'одиннадцать',
        12 => 'двенадцать',
        13 => 'тринадцать',
        14 => 'четырнадцать',
        15 => 'пятнадцать',
        16 => 'шестнадцать',
        17 => 'семнадцать',
        18 => 'восемнадцать',
        19 => 'девятнадцать',
    ];

    /**
     * @var array
     */
    private $tens = [
        20 => 'двадцать',
        30 => 'тридцать',
        40 => 'сорок',
        50 => 'пятьдесят',
        60 => 'шестьдесят',
        70 => 'семьдесят',
        80 => 'восемьдесят',
        90 => 'девяноста',
    ];

    /**
     * @var array
     */
    private $hundreds = [
        100 => 'сто',
        200 => 'двести',
        300 => 'триста',
        400 => 'четыреста',
        500 => 'пятьсот',
        600 => 'шестьсот',
        700 => 'семьсот',
        800 => 'восемьсот',
        900 => 'девятьсот'
    ];

    /**
     * @param $number
     * @param string $gender
     * @return string
     */
    public function getUnit($number, $gender = Declension::GENDER_M)
    {
        if ($gender !== Declension::GENDER_M && $gender !== Declension::GENDER_F) {
            throw new InvalidGenderException(sprintf("Gender %s not exists.", $gender));
        }

        if (! isset($this->units[$number])) {
            throw new FailedReceiveNumberFromCollectionException(sprintf('Number %s not found in units collection', $number));
        }

        return is_array($this->units[$number]) ? $this->units[$number][$gender] : $this->units[$number];
    }

    /**
     * @param $teen
     * @return string
     */
    public function getTeen($teen)
    {
        if (! isset($this->teens[$teen])) {
            throw new FailedReceiveNumberFromCollectionException(sprintf('Teen %s not found in teens collection', $teen));
        }

        return $this->teens[$teen];
    }

    /**
     * @param $ten
     * @return string
     */
    public function getTen($ten)
    {
        if (! isset($this->tens[$ten])) {
            throw new FailedReceiveNumberFromCollectionException(sprintf('Ten %s not found in tens collection', $ten));
        }

        return $this->tens[$ten];
    }

    /**
     * @param $hundred
     * @return string
     */
    public function getHundred($hundred)
    {
        if (! isset($this->hundreds[$hundred])) {
            throw new FailedReceiveNumberFromCollectionException(sprintf('Hundred %s not found in hundreds collection', $hundred));
        }

        return $this->hundreds[$hundred];
    }
}