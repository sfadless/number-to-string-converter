<?php

namespace Sfadless\Utils\Converter\Currency;

/**
 * CurrencyInterface
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
interface CurrencyInterface
{
    /**
     * @return CaseInterface
     */
    public function getInt();

    /**
     * @return CaseInterface
     */
    public function getFloat();
}