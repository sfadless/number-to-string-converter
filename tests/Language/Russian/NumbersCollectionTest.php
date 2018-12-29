<?php

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian;

use Sfadless\NumberToStringConverter\Exception\FailedReceiveNumberFromCollectionException;
use Sfadless\NumberToStringConverter\Exception\InvalidGenderException;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;
use Sfadless\NumberToStringConverter\Language\Russian\NumbersCollection;
use PHPUnit\Framework\TestCase;

/**
 * NumbersCollectionTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class NumbersCollectionTest extends TestCase
{
    /**
     * @var NumbersCollection
     */
    private $collection;

    public function setUp()
    {
        $this->collection = new NumbersCollection();
    }

    public function testGetTeen()
    {
        $this->assertEquals($this->collection->getTeen(15), 'пятнадцать');

        $this->expectException(FailedReceiveNumberFromCollectionException::class);
        $this->collection->getTeen(20);
    }

    public function testGetTen()
    {
        $this->assertEquals($this->collection->getTen(30), 'тридцать');

        $this->expectException(FailedReceiveNumberFromCollectionException::class);
        $this->collection->getTen(1);
    }

    public function testGetHundred()
    {
        $this->assertEquals($this->collection->getHundred(800), 'восемьсот');

        $this->expectException(FailedReceiveNumberFromCollectionException::class);
        $this->collection->getHundred(1);
    }

    public function testGetUnit()
    {
        $this->assertEquals($this->collection->getUnit(1), 'один');
        $this->assertEquals($this->collection->getUnit(5), 'пять');
        $this->assertEquals($this->collection->getUnit(0), 'ноль');
        $this->assertEquals($this->collection->getUnit(2, Declension::GENDER_F), 'две');

        $this->expectException(FailedReceiveNumberFromCollectionException::class);
        $this->collection->getUnit(10);
    }

    public function testExceptionOnWrongGender()
    {
        $this->expectException(InvalidGenderException::class);
        $this->collection->getUnit(7, 'r');
    }
}