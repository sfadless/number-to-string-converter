<?php
/**
 * NumberToStringConverterTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */

namespace Sfadless\NumberToStringConverter\Tests;

use Sfadless\NumberToStringConverter\Language\Russian\RussianLanguageFactory;
use Sfadless\NumberToStringConverter\NumberToStringConverter;
use PHPUnit\Framework\TestCase;

class NumberToStringConverterTest extends TestCase
{
    /**
     * @var NumberToStringConverter
     */
    private $converter;

    public function setUp()
    {
        $factory = new RussianLanguageFactory();
        $russianLanguage = $factory->create();

        $this->converter = new NumberToStringConverter($russianLanguage);
    }

    public function testConvert()
    {
        $data = [
            ['number' => 1.01, 'string' => 'один рубль одна копейка'],
            ['number' => 5, 'string' => 'пять рублей ноль копеек'],
        ];

        foreach ($data as $item) {
            $this->assertEquals(
                $this->converter->convert($item['number']),
                $item['string']
            );
        }
    }
}
