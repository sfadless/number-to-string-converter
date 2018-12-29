<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output;

/**
 * OutputMetadata
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class OutputMetadata
{
    /**
     * @var int
     */
    private $value;

    /**
     * @var string
     */
    private $string;

    /**
     * @var string
     */
    private $currency;

    /**
     * OutputMetadata constructor.
     * @param $value
     * @param $string
     * @param $currency
     */
    public function __construct($value, $string, $currency)
    {
        $this->value = $value;
        $this->string = $string;
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}