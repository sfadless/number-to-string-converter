<?php

namespace Sfadless\NumberToStringConverter\Language;

/**
 * LanguageInterface
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
interface LanguageInterface
{
    /**
     * @param $number float
     * @param array $options
     * @return string
     */
    public function convert($number, array $options = []);

    /**
     * @return string
     */
    public function getCode();
}