<?php

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian;

use Sfadless\NumberToStringConverter\Language\Russian\Currency;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionDigitMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionNumberMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\NumbersCollection;
use Sfadless\NumberToStringConverter\Language\Russian\Options;
use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadataFactory;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputVariable;
use Sfadless\NumberToStringConverter\Language\Russian\RussianLanguage;
use PHPUnit\Framework\TestCase;
use Sfadless\NumberToStringConverter\Language\Russian\SmallNumbersConverter;
use Sfadless\NumberToStringConverter\Number\NumberDivider;

/**
 * RussianLanguageTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class RussianLanguageTest extends TestCase
{
    /**
     * @var RussianLanguage
     */
    private $language;

    public function setUp()
    {
        $declensionNumberMatcher = new DeclensionNumberMatcher();

        $this->language = new RussianLanguage(
            new NumberDivider(),
            new DeclensionDigitMatcher(new SmallNumbersConverter(new NumbersCollection()), $declensionNumberMatcher),
            new OutputMetadataFactory($declensionNumberMatcher)
        );
    }

    public function testSeparateNumber()
    {
        $forTest = [
            ['number' => 102, 'integer' => 102, 'fractional' => 0],
            ['number' => 33.2, 'integer' => 33, 'fractional' => 20],
            ['number' => 22.08, 'integer' => 22, 'fractional' => 8],
            ['number' => 3.11, 'integer' => 3, 'fractional' => 11],
            ['number' => 3.66, 'integer' => 3, 'fractional' => 66],
            ['number' => 3000.0, 'integer' => 3000, 'fractional' => 0],
        ];

        foreach ($forTest as $item) {
            $separatedNumber = $this->language->separateNumber($item['number']);
            $this->assertEquals($item['integer'], $separatedNumber->getInteger());
            $this->assertEquals($item['fractional'], $separatedNumber->getFractional());
        }
    }

    public function testConvert()
    {
        $data = [
            ['number' => 101, 'string' => 'сто один рубль ноль копеек'],
            ['number' => 5327855.02, 'string' => 'пять миллионов триста двадцать семь тысяч восемьсот пятьдесят пять рублей две копейки'],
            ['number' => 805.11, 'string' => 'восемьсот пять рублей одиннадцать копеек'],
        ];

        foreach ($data as $item) {
            $this->assertEquals(
                $this->language->convert($item['number']),
                $item['string']
            );
        }
    }

    public function testConvertWithTemplate()
    {
        $template = '%i_value% %i_currency% %f_value% %f_currency%';

        $this->assertEquals(
            $this->language->convert(11.11, [Options::TEMPLATE => $template]),
            '11 рублей 11 копеек'
        );
    }

    public function testConvertWithVariable()
    {
        $template = '%some_variable%';

        $variable = new OutputVariable('some_variable', function (Output $output) {
            return sprintf(
                '%d %s. %d %s.',
                $output->getInteger()->getValue(),
                mb_substr($output->getInteger()->getCurrency(), 0, 3),
                $output->getFractional()->getValue(),
                mb_substr($output->getFractional()->getCurrency(), 0, 3)
            );
        });

        $this->assertEquals(
            $this->language->convert(11.11, [Options::TEMPLATE => $template, Options::VARIABLES => [$variable]]),
            '11 руб. 11 коп.'
        );
    }

    public function testConvertWithCurrency()
    {
        $currency = new Currency(
            new Declension('доллар', 'доллара', 'долларов', Declension::GENDER_M),
            new Declension('цент', 'цента', 'центов', Declension::GENDER_M)
        );

        $this->assertEquals(
            $this->language->convert(11.01, [Options::CURRENCY => $currency]),
            'одиннадцать долларов один цент'
        );
    }
}
