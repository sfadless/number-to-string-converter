<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;

/**
 * RussianLanguageFactory
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class RussianLanguageFactory
{
    public function createDefault()
    {
        $currency = new Currency(
            new Declension('рубль', 'рубля', 'рублей', Declension::GENDER_M),
            new Declension('копейка', 'копейки', 'копеек', Declension::GENDER_F)
        );
    }
}