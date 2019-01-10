<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionDigitMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionNumberMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadataFactory;
use Sfadless\NumberToStringConverter\Number\NumberDivider;

/**
 * RussianLanguageFactory
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class RussianLanguageFactory
{
    public function create()
    {
        $declensionNumberMatcher = new DeclensionNumberMatcher();

        return new RussianLanguage(
            new NumberDivider(),
            new DeclensionDigitMatcher(new SmallNumbersConverter(new NumbersCollection()), $declensionNumberMatcher),
            new OutputMetadataFactory($declensionNumberMatcher)
        );
    }
}