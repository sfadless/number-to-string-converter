<?php

namespace Sfadless\Utils\Converter\Currency;

/**
 * CaseInterface
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
interface CaseInterface
{
    /**
     * @param $number int
     * @param $showIfNull bool
     *
     * @return string
     */
    public function getCase($number, $showIfNull = false);

    /**
     * @return string
     */
    public function getGender();
}