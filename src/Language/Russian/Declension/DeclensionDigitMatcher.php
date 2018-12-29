<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Declension;

use Sfadless\NumberToStringConverter\Language\Russian\SmallNumbersConverter;
use Sfadless\NumberToStringConverter\Number\DividedNumber;

/**
 * DeclensionDigitMatcher
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class DeclensionDigitMatcher
{
    /**
     * @var Declension[]
     */
    private $declensionChain;
    /**
     * @var SmallNumbersConverter
     */
    private $converter;
    /**
     * @var DeclensionNumberMatcher
     */
    private $declensionNumberMatcher;

    /**
     * DeclensionDigitMather constructor.
     * @param SmallNumbersConverter $converter
     * @param Declension[] $declensionChain
     */
    public function __construct(SmallNumbersConverter $converter, DeclensionNumberMatcher $declensionNumberMatcher, array $declensionChain = [])
    {
        $this->declensionChain = empty($declensionChain) ? static::getDefaultDeclensions() : $declensionChain;
        $this->converter = $converter;
        $this->declensionNumberMatcher = $declensionNumberMatcher;
    }

    /**
     * @param DividedNumber $dividedNumber
     * @param string $gender
     * @return MatchedDeclensionDigitCollection
     */
    public function match(DividedNumber $dividedNumber, $gender = Declension::GENDER_M)
    {
        $matched = [];
        $arDividedNumber = $dividedNumber->getDigits();
        $dividedCount = count($dividedNumber);

        for ($i = $dividedCount - 1; $i >= 0; $i--) {
            if ($i === $dividedCount - 1) {
                $matched[] = new MatchedDeclensionDigit(
                    $arDividedNumber[$i],
                    $this->converter->convert($arDividedNumber[$i], $gender),
                    ''
                );

                end($this->declensionChain);
                continue;
            }

            $declension = current($this->declensionChain);

            $matched[] = new MatchedDeclensionDigit(
                $arDividedNumber[$i],
                $this->converter->convert($arDividedNumber[$i], $declension->getGender()),
                $this->declensionNumberMatcher->match($arDividedNumber[$i], $declension)
            );

            prev($this->declensionChain);
        }

        $collection = new MatchedDeclensionDigitCollection();

        foreach (array_reverse($matched) as $matchedDigit) {
            $collection->add($matchedDigit);
        }

        return $collection;
    }

    /**
     * @return array
     */
    public static function getDefaultDeclensions()
    {
        return [
            new Declension('миллиард', 'миллиарда', 'миллиардов', Declension::GENDER_M),
            new Declension('миллион', 'миллиона', 'миллионов', Declension::GENDER_M),
            new Declension('тысяча', 'тысячи', 'тысяч', Declension::GENDER_F),
        ];
    }
}