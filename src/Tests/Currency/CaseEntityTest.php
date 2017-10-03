<?php

namespace Tests\Converter\Currency;

use PHPUnit\Framework\TestCase;
use Sfadless\Utils\Converter\Currency\CaseEntity;

/**
 * CaseEntityTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class CaseEntityTest extends TestCase
{
    public function testGetCase()
    {
        $arCurrency = ['рубль', 'рублей', 'рубля'];

        $case = new CaseEntity($arCurrency);

        $this->assertEquals($case->getCase('1'), $arCurrency[0]);
        $this->assertEquals($case->getCase('101'), $arCurrency[0]);
        $this->assertEquals($case->getCase('21'), $arCurrency[0]);
        $this->assertEquals($case->getCase('10000001'), $arCurrency[0]);

        $this->assertEquals($case->getCase('2'), $arCurrency[2]);
        $this->assertEquals($case->getCase('102'), $arCurrency[2]);
        $this->assertEquals($case->getCase('32'), $arCurrency[2]);
        $this->assertEquals($case->getCase('93'), $arCurrency[2]);
        $this->assertEquals($case->getCase('44'), $arCurrency[2]);
        $this->assertEquals($case->getCase('5'), $arCurrency[1]);
        $this->assertEquals($case->getCase('11'), $arCurrency[1]);
        $this->assertEquals($case->getCase('19'), $arCurrency[1]);
        $this->assertEquals($case->getCase('45'), $arCurrency[1]);
        $this->assertEquals($case->getCase('56'), $arCurrency[1]);
        $this->assertEquals($case->getCase('99'), $arCurrency[1]);

        $this->assertEquals($case->getCase(''), '');
        $this->assertEquals($case->getCase(false), '');
        $this->assertEquals($case->getCase(null), '');
        $this->assertEquals($case->getCase(0), '');

        $this->assertEquals($case->getCase(0, true), $arCurrency[1]);
        $this->assertEquals($case->getCase(false, true), $arCurrency[1]);

    }
}