<?php

namespace Sfadless\Utils\Converter;

use Sfadless\Utils\Converter\Currency\CaseEntity;
use Sfadless\Utils\Converter\Currency\CaseInterface;
use Sfadless\Utils\Converter\Currency\CurrencyInterface;
use Sfadless\Utils\Converter\Currency\Currency;

/**
 * NumberToStringConverter
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class NumberToStringConverter
{
    /**
     * @var array
     */
    private $units = [
        ['m' => 'один', 'f' => 'одна'],
        ['m' => 'два', 'f' => 'две'],
        'три',
        'четыре',
        'пять',
        'шесть',
        'семь',
        'восемь',
        'девять'
    ];

    /**
     * @var array
     */
    private $teens = [
        'десять',
        'одиннадцать',
        'двенадцать',
        'тринадцать',
        'четырнадцать',
        'пятнадцать',
        'шестнадцать',
        'семнадцать',
        'восемнадцать',
        'девятнадцать',
    ];

    /**
     * @var array
     */
    private $tens = [
        'двадцать',
        'тридцать',
        'сорок',
        'пятьдесят',
        'шестьдесят',
        'семьдесят',
        'восемдесят',
        'девяноста',
    ];

    /**
     * @var array
     */
    private $hundreds = [
        'сто',
        'двести',
        'триста',
        'четыреста',
        'пятьсот',
        'шестьсот',
        'семьсот',
        'восемьсот',
        'девятьсот'
    ];

    /**
     * @var array
     */
    private $cases;

    /**
     * @var CurrencyInterface
     */
    private $currency;

    /**
     * NumberToStringConverter constructor.
     * @param $currency CurrencyInterface
     */
    public function __construct($currency = null)
    {
        if (!$currency || !$currency instanceof CurrencyInterface) {
            $this->currency = new Currency(
                new CaseEntity(['рубль', 'рублей', 'рубля'], 'm'),
                new CaseEntity(['копейка', 'копеек', 'копейки'], 'f')
            );
        } else {
            $this->currency = $currency;
        }

        $this->cases = [
            new CaseEntity(['тысяча', 'тысяч', 'тысячи'], 'f'),
            new CaseEntity(['миллион', 'миллионов', 'миллиона'], 'm'),
            new CaseEntity(['миллиард', 'миллиардов', 'миллиарда'], 'm')
        ];
    }

    /**
     * @param $currency Currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param $number float
     * @param $options array
     *
     * @return string
     */
    public function convert($number, $options = [])
    {
        $int = (int) $number;

        $orders = $this->getOrders($int);

        $compared = $this->compareOrdersAndCases($orders, $this->cases);

        $converted = $this->convertCompared($compared);

        if (isset($options['withoutCurrency']) && $options['withoutCurrency'] === true) {
            unset($converted[count($converted) - 1][1]);
        } else {
            $float = $this->getFloatFromNumber($number);

            $converted[] = $this->getConvertedCompareInstance(
                $float,
                $this->currency->getFloat(),
                isset($options['floatAsNumber']) && $options['floatAsNumber'] === true
            );
        }

        $combined = $this->combineConverted($converted);

        return implode(' ', $combined);
    }

    public function getFloatFromNumber($number)
    {
        $ar = explode('.', (string) $number);

        if (!isset($ar[1])) {
            return 0;
        }

        if (strlen($ar[1]) === 1) {
            $ar[1] .= '0';
        }

        if (strlen($ar[1]) > 2) {
            $ar[1] = substr($ar[1], 0, 2);
        }

        return (int) $ar[1];
    }

    /**
     * Сопоставляет массив порядков с массивом падежей
     *
     * На выходе получаем массив вида [[12, CaseEntity (миллионы)], [2, CaseEntity (тысячи)], [556]]
     *
     * @param $orders array
     * @param $cases array
     * @return array
     */
    private function compareOrdersAndCases($orders, $cases)
    {
        $compared = [];

        //число для сопоставления падежей и порядков
        $compNum = count($orders) - 2;

        foreach ($orders as $key => $order) {
            $compared[$key] = [$order];
            $caseNum = $compNum - $key;

            if ($caseNum >= 0) {
                $case = $cases[$caseNum];

                if ($case instanceof CaseInterface) {
                    $compared[$key][] = $case;
                }
            }
        }

        return $compared;
    }

    /**
     * @param $compared array
     * @return array
     */
    private function convertCompared($compared)
    {
        $converted = [];

        foreach ($compared as $key => $order) {
            $number = (int) $order[0];

            $needCase = isset($order[1]);

            $case = $needCase ? $order[1] : $this->currency->getInt();

            $converted[] = $this->getConvertedCompareInstance($number, $case);
        }

        return $converted;
    }

    /**
     * @param $number int
     * @param $case CaseInterface
     * @param $asNumber bool
     *
     * @return array
     */
    private function getConvertedCompareInstance($number, $case, $asNumber = false)
    {
        return [
            $asNumber ? $number : $this->getNumberString($number, $case->getGender()),
            $case->getCase($number, $case === $this->currency->getInt())
        ];
    }

    /**
     * Возвращает массив с порядками вида [12, 123, 456]
     * Например, для числа 12006455 вернет [12, 006, 455]
     *
     * @param $number
     *
     * @return array
     */
    protected function getOrders($number)
    {
        if ((int) $number < 1000) {
            return [(int) $number];
        }

        $string = (string) $number;
        $len = strlen($string);
        $orders = [];
        $notFull = $len % 3;

        if ($notFull) {
            $orders[] = mb_substr($string, 0, $notFull);
        }

        for ($i = $notFull; $i < $len; $i += 3) {
            $orders[] = mb_substr($string, $i, 3);
        }

        return $orders;
    }

    /**
     * Функция преобразования трехзначного (максимум) числа в текст.
     *
     * @param $order
     * @param string $gender
     * @return bool|string
     */
    private function getNumberString($order, $gender = 'm')
    {
        if ($gender !== 'm' && $gender !== 'f') {
            return false;
        }

        if ($order <= 0 || $order >= 1000) {
            return '';
        }

        $number = (string) $order;

        $unit = (int) mb_substr($number, -1, 1);

        $ten = $order > 9 ? (int) mb_substr($number, -2, 1) : false;

        $hundred = $order > 99 ? (int) mb_substr($number, -3, 1) : false;

        $string = '';

        if ($hundred) {
            $string .= $this->hundreds[$hundred - 1] . ' ';
        }

        if ($ten > 1) {
            $string .= $this->tens[$ten - 2] . ' ';
        }

        if ($ten == 1) {
            $string .= $this->teens[$unit];

            return $string;
        }

        if ($unit) {
            $string .= ($unit <= 2) ? $this->units[$unit - 1][$gender] : $this->units[$unit - 1];
        }

        return trim($string);
    }

    /**
     * @param $converted
     * @return array
     */
    private function combineConverted($converted)
    {
        $combined = [];

        foreach ($converted as $ar) {
            $unit = trim(implode(' ', $ar));

            if ($unit) {
                $combined[] = $unit;
            }
        }

        return $combined;
    }
}