<?php

namespace Tests\Converter;

use PHPUnit\Framework\TestCase;
use Sfadless\Utils\Converter\Currency\CaseEntity;
use Sfadless\Utils\Converter\NumberToStringConverter;

/**
 * NumberToStringConverterTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class NumberToStringConverterTest extends TestCase
{
    public function testConvert()
    {
        $converter = new NumberToStringConverter();

        $this->assertEquals($converter->convert(1), 'один рубль');
        $this->assertEquals($converter->convert(2), 'два рубля');
        $this->assertEquals($converter->convert(5), 'пять рублей');
        $this->assertEquals($converter->convert(6), 'шесть рублей');
        $this->assertEquals($converter->convert(7), 'семь рублей');
        $this->assertEquals($converter->convert(8), 'восемь рублей');
        $this->assertEquals($converter->convert(9), 'девять рублей');
        $this->assertEquals($converter->convert(10), 'десять рублей');
        $this->assertEquals($converter->convert(11.62), 'одиннадцать рублей шестьдесят две копейки');
        $this->assertEquals($converter->convert(12.50), 'двенадцать рублей пятьдесят копеек');
        $this->assertEquals($converter->convert(13.01), 'тринадцать рублей одна копейка');
        $this->assertEquals($converter->convert(14.20), 'четырнадцать рублей двадцать копеек');
        $this->assertEquals($converter->convert(15.55), 'пятнадцать рублей пятьдесят пять копеек');
        $this->assertEquals($converter->convert(101), 'сто один рубль');
        $this->assertEquals($converter->convert(300), 'триста рублей');
        $this->assertEquals($converter->convert(1000000), 'один миллион рублей');
        $this->assertEquals($converter->convert(1000001), 'один миллион один рубль');
        $this->assertEquals($converter->convert(1000000000), 'один миллиард рублей');

        $this->assertEquals($converter->convert(1.1), 'один рубль десять копеек');
        $this->assertEquals($converter->convert(1.10), 'один рубль десять копеек');
        $this->assertEquals($converter->convert(1.01), 'один рубль одна копейка');
        $this->assertEquals($converter->convert(1.5), 'один рубль пятьдесят копеек');
        $this->assertEquals($converter->convert(1.99), 'один рубль девяноста девять копеек');
    }

    public function testGetFloat()
    {
        $converter = new NumberToStringConverter();

        $this->assertEquals($converter->getFloatFromNumber(1.01), 1);
        $this->assertEquals($converter->getFloatFromNumber(13.01), 1);
        $this->assertEquals($converter->getFloatFromNumber(1.55), 55);
        $this->assertEquals($converter->getFloatFromNumber(1.22), 22);
        $this->assertEquals($converter->getFloatFromNumber(1.20), 20);
        $this->assertEquals($converter->getFloatFromNumber(1.02), 2);
        $this->assertEquals($converter->getFloatFromNumber(1.259), 25);
        $this->assertEquals($converter->getFloatFromNumber(1.99), 99);
        $this->assertEquals($converter->getFloatFromNumber(1), 0);
    }

    public function testGetOrders()
    {
        $converter = new NumberToStringConverter();
        $class = new \ReflectionClass(NumberToStringConverter::class);
        $method = $class->getMethod('getOrders');
        $method->setAccessible(true);

        $this->assertEquals($method->invokeArgs($converter, [1]), [1]);
        $this->assertEquals($method->invokeArgs($converter, [20]), [20]);
        $this->assertEquals($method->invokeArgs($converter, [501]), [501]);
        $this->assertEquals($method->invokeArgs($converter, [1000]), [1, 0]);
        $this->assertEquals($method->invokeArgs($converter, [100000]), [100, 0]);
        $this->assertEquals($method->invokeArgs($converter, [1000000]), [1, 0, 0]);
        $this->assertEquals($method->invokeArgs($converter, [1000001]), [1, 0, 1]);
        $this->assertEquals($method->invokeArgs($converter, [1000001001]), [1, 0, 1, 1]);
        $this->assertEquals($method->invokeArgs($converter, [1200001001]), [1, 200, 1, 1]);
    }

    public function testGetNumberString()
    {
        $converter = new NumberToStringConverter();
        $class = new \ReflectionClass(NumberToStringConverter::class);
        $method = $class->getMethod('getNumberString');
        $method->setAccessible(true);

        $this->assertEquals($method->invokeArgs($converter, [1]), 'один');
        $this->assertEquals($method->invokeArgs($converter, [1, 'm']), 'один');
        $this->assertEquals($method->invokeArgs($converter, [1, 'f']), 'одна');
        $this->assertEquals($method->invokeArgs($converter, [2, 'f']), 'две');
        $this->assertEquals($method->invokeArgs($converter, [2]), 'два');
        $this->assertEquals($method->invokeArgs($converter, [100]), 'сто');
        $this->assertEquals($method->invokeArgs($converter, [200]), 'двести');
        $this->assertEquals($method->invokeArgs($converter, [300]), 'триста');
        $this->assertEquals($method->invokeArgs($converter, [400]), 'четыреста');
        $this->assertEquals($method->invokeArgs($converter, [500]), 'пятьсот');
        $this->assertEquals($method->invokeArgs($converter, [600]), 'шестьсот');
        $this->assertEquals($method->invokeArgs($converter, [999]), 'девятьсот девяноста девять');
        $this->assertEquals($method->invokeArgs($converter, [901, 'f']), 'девятьсот одна');
        $this->assertEquals($method->invokeArgs($converter, [11]), 'одиннадцать');
        $this->assertEquals($method->invokeArgs($converter, [12]), 'двенадцать');
        $this->assertEquals($method->invokeArgs($converter, [332, 'f']), 'триста тридцать две');
        $this->assertEquals($method->invokeArgs($converter, [0]), '');
        $this->assertEquals($method->invokeArgs($converter, [204]), 'двести четыре');
        $this->assertEquals($method->invokeArgs($converter, [55, 'f']), 'пятьдесят пять');
    }

    public function testConvertWithOptions()
    {
        $converter = new NumberToStringConverter();

        $this->assertEquals($converter->convert(33.54, ['floatAsNumber' => true]), 'тридцать три рубля 54 копейки');
        $this->assertEquals($converter->convert(1.01, ['floatAsNumber' => true]), 'один рубль 1 копейка');
        $this->assertEquals($converter->convert(1.10, ['floatAsNumber' => true]), 'один рубль 10 копеек');
    }
}