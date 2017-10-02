<?php

namespace Sfadless\Utils\Converter\Currency;

/**
 * Rubles
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class Currency implements CurrencyInterface
{
    /**
     * @var CaseEntity
     */
    private $int;

    /**
     * @var CaseEntity
     */
    private $float;

    /**
     * Currency constructor.
     * @param $int CaseEntity
     * @param $float CaseEntity
     */
    public function __construct($int, $float)
    {
        $this->int = $int;
        $this->float = $float;
    }

    /**
     * @return CaseInterface
     */
    public function getInt()
    {
        return $this->int;
    }

    /**
     * @return CaseInterface
     */
    public function getFloat()
    {
        return $this->float;
    }
}