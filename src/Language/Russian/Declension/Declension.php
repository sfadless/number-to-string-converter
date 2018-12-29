<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Declension;

/**
 * Declension
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class Declension
{
    const GENDER_M = 'm';
    const GENDER_F = 'f';

    /**
     * @var string
     */
    private $one;

    /**
     * @var string
     */
    private $few;

    /**
     * @var string
     */
    private $many;

    /**
     * @var string
     */
    private $gender;

    /**
     * Declension constructor.
     * @param string $one
     * @param string $few
     * @param string $many
     * @param string $gender
     */
    public function __construct($one, $few, $many, $gender)
    {
        $this->one = $one;
        $this->few = $few;
        $this->many = $many;
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * @return string
     */
    public function getFew()
    {
        return $this->few;
    }

    /**
     * @return string
     */
    public function getMany()
    {
        return $this->many;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }
}