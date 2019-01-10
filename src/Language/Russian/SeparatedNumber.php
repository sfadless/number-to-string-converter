<?php

namespace Sfadless\NumberToStringConverter\Language\Russian;

/**
 * SeparatedNumber
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class SeparatedNumber
{
    /**
     * @var integer
     */
    private $fractional;

    /**
     * @var integer
     */
    private $integer;

    /**
     * SeparatedNumber constructor.
     * @param int $fractional
     * @param int $integer
     */
    public function __construct($integer, $fractional)
    {
        $this->fractional = $fractional;
        $this->integer = $integer;
    }

    /**
     * @return int
     */
    public function getFractional()
    {
        return $this->fractional;
    }

    /**
     * @return int
     */
    public function getInteger()
    {
        return $this->integer;
    }
}