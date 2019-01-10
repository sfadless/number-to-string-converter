<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

use Sfadless\NumberToStringConverter\Language\LanguageInterface;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionDigitMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadataFactory;
use Sfadless\NumberToStringConverter\Number\NumberDivider;

/**
 * RussianLanguage
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class RussianLanguage implements LanguageInterface
{
    const CODE = 'RUS';

    /**
     * @var NumberDivider
     */
    private $numberDivider;

    /**
     * @var DeclensionDigitMatcher
     */
    private $declensionDigitMather;

    /**
     * @var OutputMetadataFactory
     */
    private $outputMetadataFactory;

    /**
     * @param float $number
     * @param array $options
     * @return string
     */
    public function convert($number, array $options = [])
    {
        $separatedNumber = $this->separateNumber($number);

        $currency = isset($options[Options::CURRENCY]) ? $options[Options::CURRENCY] : $this->getDefaultCurrency();
        $template = isset($options[Options::TEMPLATE]) ? $options[Options::TEMPLATE] : Output::DEFAULT_TEMPLATE;
        $variables = isset($options[Options::VARIABLES]) ? $options[Options::VARIABLES] : [];

        $integerCollection = $this->declensionDigitMather->match(
            $this->numberDivider->divide($separatedNumber->getInteger()),
            $currency->getInteger()->getGender()
        );

        $fractionalCollection = $this->declensionDigitMather->match(
            $this->numberDivider->divide($separatedNumber->getFractional()),
            $currency->getFractional()->getGender()
        );

        $integer = $this->outputMetadataFactory->create($separatedNumber->getInteger(), $integerCollection, $currency->getInteger());
        $fractional = $this->outputMetadataFactory->create($separatedNumber->getFractional(), $fractionalCollection, $currency->getFractional());

        $output = new Output($integer, $fractional, $template);

        foreach ($variables as $variable) {
            $output->addVariable($variable);
        }

        return $output->output();
    }

    /**
     * RussianLanguage constructor.
     * @param NumberDivider $numberDivider
     * @param DeclensionDigitMatcher $declensionDigitMather
     * @param OutputMetadataFactory $outputMetadataFactory
     */
    public function __construct(
        NumberDivider $numberDivider,
        DeclensionDigitMatcher $declensionDigitMather,
        OutputMetadataFactory $outputMetadataFactory
    ) {
        $this->numberDivider = $numberDivider;
        $this->declensionDigitMather = $declensionDigitMather;
        $this->outputMetadataFactory = $outputMetadataFactory;
    }

    /**
     * @return Currency
     */
    private function getDefaultCurrency()
    {
        return new Currency(
            new Declension('рубль', 'рубля', 'рублей', Declension::GENDER_M),
            new Declension('копейка', 'копейки', 'копеек', Declension::GENDER_F)
        );
    }

    /**
     * @param $number float
     * @return SeparatedNumber
     */
    public function separateNumber($number)
    {
        if (! is_float($number)) {
            return new SeparatedNumber((int) $number, 0);
        }

        $string = (string) $number;
        $separated = explode('.', $string);
        list($integer, $fractional) = $separated;

        if (strlen($fractional) === 1) {
            $fractional .= '0';
        }

        return new SeparatedNumber((int) $integer, (int) $fractional);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return static::CODE;
    }
}