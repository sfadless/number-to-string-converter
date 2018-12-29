<?php

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian\Output;

use Sfadless\NumberToStringConverter\Language\Russian\Currency;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionDigitMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionNumberMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\NumbersCollection;
use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;
use PHPUnit\Framework\TestCase;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadata;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadataFactory;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputVariable;
use Sfadless\NumberToStringConverter\Language\Russian\SmallNumbersConverter;
use Sfadless\NumberToStringConverter\Number\NumberDivider;

/**
 * OutputTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class OutputTest extends TestCase
{
    public function testOutputOneVariable()
    {
        $output = $this->getOutputWithTemplate('%i_string%');

        $this->assertEquals(
            'сто двадцать три',
            $output->output()
        );
    }

    public function testFullOutputWithDefaultTemplate()
    {
        $output = $this->getOutputWithTemplate(Output::DEFAULT_TEMPLATE);

        $this->assertEquals(
            'сто двадцать три рубля восемьдесят девять копеек',
            $output->output()
        );
    }

    public function testOutputWithInt()
    {
        $output = $this->getOutputWithTemplate('%i_value% %i_currency% %f_value% %f_currency%');

        $this->assertEquals(
            '123 рубля 89 копеек',
            $output->output()
        );
    }

    public function testAddVariable()
    {
        $output = $this->getOutputWithTemplate('%i_value% %i_short_currency%');

        $variable = new OutputVariable('i_short_currency', function (Output $output) {
            return mb_substr($output->getInteger()->getCurrency(), 0, 3);
        });

        $output->addVariable($variable);

        $this->assertEquals(
            "123 руб",
            $output->output()
        );
    }

    public function testOutputWithMetadataFactory()
    {
        $output = $this->getOutputForNumber(3987001, 71);

        $this->assertEquals(
            $output->output(),
            'три миллиона девятьсот восемьдесят семь тысяч один рубль семьдесят одна копейка'
        );

        $output = $this->getOutputForNumber(1, 0);

        $this->assertEquals(
            $output->output(),
            'один рубль ноль копеек'
        );
    }

    public function testOutputWithZeros()
    {
        $output = new Output(
            new OutputMetadata(0, 'ноль', 'рублей'),
            new OutputMetadata(0, 'ноль', 'копеек')
        );

        $this->assertEquals(
            "ноль рублей ноль копеек",
            $output->output()
        );
    }

    private function getOutputForNumber($numberInteger, $numberFractional, $template = Output::DEFAULT_TEMPLATE)
    {
        $currency = new Currency(
            new Declension('рубль', 'рубля', 'рублей', Declension::GENDER_M),
            new Declension('копейка', 'копейки', 'копеек', Declension::GENDER_F)
        );

        $declensionNumberMatcher = new DeclensionNumberMatcher();
        $numberDivider = new NumberDivider();
        $declensionDigitMather = new DeclensionDigitMatcher(new SmallNumbersConverter(new NumbersCollection()), $declensionNumberMatcher);

        $factory = new OutputMetadataFactory($declensionNumberMatcher);

        $integerCollection = $declensionDigitMather->match(
            $numberDivider->divide($numberInteger),
            $currency->getInteger()->getGender()
        );

        $fractionalCollection = $declensionDigitMather->match(
            $numberDivider->divide($numberFractional),
            $currency->getFractional()->getGender()
        );

        $integer = $factory->create($numberInteger, $integerCollection, $currency->getInteger());
        $fractional = $factory->create($numberFractional, $fractionalCollection, $currency->getFractional());

        return new Output($integer, $fractional, $template);
    }

    private function getOutputWithTemplate($template)
    {
        return new Output(
            new OutputMetadata(123, 'сто двадцать три', 'рубля'),
            new OutputMetadata(89, 'восемьдесят девять', 'копеек'),
            $template
        );
    }
}
