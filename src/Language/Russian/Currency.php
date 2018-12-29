<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;

/**
 * Currency
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class Currency
{
    /**
     * @var Declension
     */
    private $integer;

    /**
     * @var Declension
     */
    private $fractional;

    /**
     * Currency constructor.
     * @param Declension $integer
     * @param Declension $fractional
     */
    public function __construct(Declension $integer, Declension $fractional)
    {
        $this->integer = $integer;
        $this->fractional = $fractional;
    }

    /**
     * @return Declension
     */
    public function getInteger(): Declension
    {
        return $this->integer;
    }

    /**
     * @return Declension
     */
    public function getFractional(): Declension
    {
        return $this->fractional;
    }
}