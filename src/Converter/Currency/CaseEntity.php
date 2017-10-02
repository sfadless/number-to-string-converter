<?php

namespace Sfadless\Utils\Converter\Currency;

/**
 * CaseEntity
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class CaseEntity implements CaseInterface
{
    /**
     * @var array
     */
    private $case;

    /**
     * @var string
     */
    private $gender;

    /**
     * CaseEntity constructor.
     * @param $case array
     * @param string $gender
     */
    public function __construct($case, $gender = 'm')
    {
        $this->case = $case;
        $this->gender = $gender;
    }

    /**
     * @param int $number
     * @return mixed|null
     */
    public function getCase($number)
    {
        if (!$number) {
            return '';
        }

        $lastNumbers = $number < 100 ? $number : $number % 100;
        $lastNumber = $lastNumbers % 10;

        switch (true) {
            case ($lastNumbers >= 11 && $lastNumbers <= 20) || $lastNumber >= 5 || !$lastNumber : return $this->case['1'];
            case $lastNumbers % 10 === 1 : return $this->case['0'];
            default : return $this->case['2'];
        }
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }
}