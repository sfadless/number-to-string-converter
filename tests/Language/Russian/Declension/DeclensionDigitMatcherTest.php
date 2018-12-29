<?php
/**
 * DeclensionDigitMatcherTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian\Declension;

use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionDigitMatcher;
use PHPUnit\Framework\TestCase;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionNumberMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\NumbersCollection;
use Sfadless\NumberToStringConverter\Language\Russian\SmallNumbersConverter;
use Sfadless\NumberToStringConverter\Number\DividedNumber;

class DeclensionDigitMatcherTest extends TestCase
{
    /**
     * @var DeclensionDigitMatcher
     */
    private $matcher;

    public function setUp()
    {
        $converter = new SmallNumbersConverter(new NumbersCollection());
        $this->matcher = new DeclensionDigitMatcher($converter, new DeclensionNumberMatcher());
    }

    public function testMatch()
    {
        $number = new DividedNumber();

        $number
            ->addDigit(5)
            ->addDigit(849)
            ->addDigit(0)
            ->addDigit(100)
        ;

        $matched = $this->matcher->match($number)->getCollection();

        $this->assertEquals($matched[0]->getDigit(), 5);
        $this->assertEquals($matched[1]->getDigit(), 849);
        $this->assertEquals($matched[2]->getDigit(), 0);
        $this->assertEquals($matched[3]->getDigit(), 100);

        $this->assertEquals($matched[0]->getDeclension(), 'миллиардов');
        $this->assertEquals($matched[1]->getDeclension(), 'миллионов');
        $this->assertEquals($matched[2]->getDeclension(), 'тысяч');
        $this->assertEquals($matched[3]->getDeclension(), '');

        $this->assertEquals($matched[0]->getDigitString(), 'пять');
        $this->assertEquals($matched[1]->getDigitString(), 'восемьсот сорок девять');
        $this->assertEquals($matched[2]->getDigitString(), 'ноль');
        $this->assertEquals($matched[3]->getDigitString(), 'сто');
    }

    public function testMatchSmallNumber()
    {
        $number = new DividedNumber();

        $number
            ->addDigit(100)
        ;

        $matched = $this->matcher->match($number)->getCollection();

        $this->assertEquals($matched[0]->getDigit(), 100);
        $this->assertEquals($matched[0]->getDeclension(), '');
        $this->assertEquals($matched[0]->getDigitString(), 'сто');
    }
}
