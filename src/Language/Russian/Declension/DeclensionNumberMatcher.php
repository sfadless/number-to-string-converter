<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Declension;

/**
 * DeclensionNumberMatcher
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class DeclensionNumberMatcher
{
    public function match($number, Declension $declension)
    {
        $tens = $number % 100;

        if ($tens >= 10 && $tens <= 20) {
            return $declension->getMany();
        }

        $unit = $tens % 10;

        if ($unit === 1) {
            return $declension->getOne();
        }

        if ($unit >= 2 && $unit <= 4) {
            return $declension->getFew();
        }

        return $declension->getMany();
    }
}