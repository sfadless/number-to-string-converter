<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output;

/**
 * OutputVariable
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class OutputVariable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callback;

    /**
     * OutputVariable constructor.
     * @param $name
     * @param $callback callable
     */
    public function __construct($name, $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Output $output
     * @return string
     */
    public function handle(Output $output)
    {
        return call_user_func($this->callback, $output);
    }
}