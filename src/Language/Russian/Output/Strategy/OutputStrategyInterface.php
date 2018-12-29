<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output\Strategy;

use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;

/**
 * OutputStrategyInterface
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
interface OutputStrategyInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param Output $output
     * @return string
     */
    public function output(Output $output);
}