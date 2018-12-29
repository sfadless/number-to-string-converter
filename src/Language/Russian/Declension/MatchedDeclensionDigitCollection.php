<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Declension;

/**
 * MatchedDeclensionDigitCollection
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class MatchedDeclensionDigitCollection implements \Countable
{
    /**
     * @var MatchedDeclensionDigit[]
     */
    private $collection;

    /**
     * @param MatchedDeclensionDigit $declensionDigit
     * @return $this
     */
    public function add(MatchedDeclensionDigit $declensionDigit)
    {
        $this->collection[] = $declensionDigit;

        return $this;
    }

    /**
     * @return MatchedDeclensionDigit[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }
}