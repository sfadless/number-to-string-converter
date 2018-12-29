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
        $numberInteger = 1;
        $numberFractional = 2;

        $currency = new Currency(
            new Declension('рубль', 'рубля', 'рублей', Declension::GENDER_M),
            new Declension('копейка', 'копейки', 'копеек', Declension::GENDER_F)
        );

        $integerCollection = $this->declensionDigitMather->match(
            $this->numberDivider->divide($numberInteger),
            $currency->getInteger()->getGender()
        );

        $fractionalCollection = $this->declensionDigitMather->match(
            $this->numberDivider->divide($numberFractional),
            $currency->getFractional()->getGender()
        );

        $integer = $this->outputMetadataFactory->create($numberInteger, $integerCollection, $currency->getInteger());
        $fractional = $this->outputMetadataFactory->create($numberFractional, $fractionalCollection, $currency->getFractional());

        $output = new Output($integer, $fractional, Output::DEFAULT_TEMPLATE);
    }

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
     * @return string
     */
    public function getCode()
    {
        return static::CODE;
    }
}