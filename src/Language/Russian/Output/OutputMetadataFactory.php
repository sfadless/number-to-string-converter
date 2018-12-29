<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output;

use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionNumberMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\MatchedDeclensionDigitCollection;

/**
 * OutputMetadataFactory
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class OutputMetadataFactory
{
    /**
     * @var DeclensionNumberMatcher
     */
    private $declensionNumberMatcher;

    /**
     * OutputMetadataFactory constructor.
     * @param DeclensionNumberMatcher $declensionNumberMatcher
     */
    public function __construct(DeclensionNumberMatcher $declensionNumberMatcher)
    {
        $this->declensionNumberMatcher = $declensionNumberMatcher;
    }

    /**
     * @param $number
     * @param MatchedDeclensionDigitCollection $collection
     * @param Declension $currency
     * @return OutputMetadata
     */
    public function create($number, MatchedDeclensionDigitCollection $collection, Declension $currency)
    {
        return new OutputMetadata(
            $number,
            $this->combineMatchedDeclensionDigitCollection($collection),
            $this->declensionNumberMatcher->match($number, $currency)
        );
    }

    /**
     * @param MatchedDeclensionDigitCollection $collection
     *
     * @return string
     */
    public function combineMatchedDeclensionDigitCollection(MatchedDeclensionDigitCollection $collection)
    {
        $result = [];

        foreach ($collection->getCollection() as $declensionDigit) {
            if (1 === count($collection) && 0 === $declensionDigit->getDigit()) {
                return 'ноль';
            }

            if ($declensionDigit->getDigit() <= 0) {
                continue;
            }

            $result[] = $declensionDigit->getDigitString();

            if (strlen($declensionDigit->getDeclension()) > 0) {
                $result[] = $declensionDigit->getDeclension();
            }
        }

        return implode(" ", $result);
    }
}