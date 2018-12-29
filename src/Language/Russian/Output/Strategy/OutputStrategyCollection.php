<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output\Strategy;

use Sfadless\NumberToStringConverter\Exception\OutputStrategyNotFoundException;

/**
 * OutputStrategyCollection
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class OutputStrategyCollection
{
    /**
     * @var array
     */
    private $collection = [];

    /**
     * @param OutputStrategyInterface $outputStrategy
     */
    public function addOutputStrategy(OutputStrategyInterface $outputStrategy)
    {
        $this->collection[$outputStrategy->getName()] = $outputStrategy;
    }

    /**
     * @param $name
     * @return mixed
     * @throws OutputStrategyNotFoundException
     */
    public function getOutputStrategy($name)
    {
        if (! isset($this->collection['name'])) {
            throw new OutputStrategyNotFoundException(sprintf("Output strategy %s not found", $name));
        }

        return $this->collection['name'];
    }
}