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
     * @return string
     */
    public function getCase($number);

    /**
     * @return string
     */
    public function getGender();
}