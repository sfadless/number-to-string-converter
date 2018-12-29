<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output\Strategy;

use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;

/**
 * FloatAsNumberOutputStrategy
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class FloatAsNumberOutputStrategy implements OutputStrategyInterface
{
    const NAME = 'FLOAT_AS_NUMBER';

    const TEMPLATE = "";

    public function getName()
    {
        return FloatAsNumberOutputStrategy::NAME;
    }

    public function output(Output $output)
    {
        $output
            ->setTemplate()
            ->output()
        ;
    }
}