<?php

namespace Sfadless\NumberToStringConverter\Tests\Number;

use PHPUnit\Framework\TestCase;
use Sfadless\NumberToStringConverter\Number\NumberDivider;

class NumberDividerTest extends TestCase
{
    /**
     * @var NumberDivider
     */
    private $divider;

    public function setUp()
    {
        $this->divider = new NumberDivider();
    }

    public function testDivideNumberLessThan1000()
    {
        $divided = $this->divider->divide(5);

        $this->assertEquals([5], $divided->getDigits());
    }

    public function testDivideNumberGreaterThan1000()
    {
        $divided = $this->divider->divide(1011);

        $this->assertEquals([1, 11], $divided->getDigits());
    }

    public function testDivideLargeNumber()
    {
        $number = 75000101002754;

        $divided = $this->divider->divide($number);

        $this->assertEquals([75, 0, 101, 2, 754], $divided->getDigits());
    }
}
