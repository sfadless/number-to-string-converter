<?php
/**
 * SmallNumbersConverterTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian;

use PHPUnit\Framework\TestCase;
use Sfadless\NumberToStringConverter\Language\Russian\NumbersCollection;
use Sfadless\NumberToStringConverter\Language\Russian\SmallNumbersConverter;

class SmallNumbersConverterTest extends TestCase
{
    /**
     * @var SmallNumbersConverter
     */
    private $converter;

    public function setUp()
    {
        $this->converter = new SmallNumbersConverter(new NumbersCollection());
    }

    public function testConvert()
    {
        $data = [
            ['number' => 3, 'gender' => 'm', 'converted' => 'три'],
            ['number' => 0, 'gender' => 'm', 'converted' => 'ноль'],
            ['number' => 2, 'gender' => 'm', 'converted' => 'два'],
            ['number' => 2, 'gender' => 'f', 'converted' => 'две'],
            ['number' => 1, 'gender' => 'm', 'converted' => 'один'],
            ['number' => 1, 'gender' => 'f', 'converted' => 'одна'],
            ['number' => 20, 'gender' => 'm', 'converted' => 'двадцать'],
            ['number' => 19, 'gender' => 'm', 'converted' => 'девятнадцать'],
            ['number' => 11, 'gender' => 'm', 'converted' => 'одиннадцать'],
            ['number' => 999, 'gender' => 'm', 'converted' => 'девятьсот девяноста девять'],
            ['number' => 100, 'gender' => 'm', 'converted' => 'сто'],
            ['number' => 201, 'gender' => 'f', 'converted' => 'двести одна'],
            ['number' => 502, 'gender' => 'm', 'converted' => 'пятьсот два'],
            ['number' => 30, 'gender' => 'm', 'converted' => 'тридцать'],
            ['number' => 590, 'gender' => 'm', 'converted' => 'пятьсот девяноста'],
        ];

        foreach ($data as $item) {
            $this->assertEquals(
                $this->converter->convert($item['number'], $item['gender']),
                $item['converted']
            );
        }
    }
}
