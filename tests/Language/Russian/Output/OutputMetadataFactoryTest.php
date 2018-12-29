<?php
/**
 * OutputMetadataFactoryTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian\Output;

use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\DeclensionNumberMatcher;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\MatchedDeclensionDigit;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\MatchedDeclensionDigitCollection;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadataFactory;
use PHPUnit\Framework\TestCase;

class OutputMetadataFactoryTest extends TestCase
{
    /**
     * @var OutputMetadataFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new OutputMetadataFactory(new DeclensionNumberMatcher());
    }

    public function testCreate()
    {
        $currency = new Declension('рубль', 'рубля', 'рублей', Declension::GENDER_M);

        $collection = new MatchedDeclensionDigitCollection();

        $number = 11085;

        $collection
            ->add(new MatchedDeclensionDigit(11, 'одиннадцать', 'тысяч'))
            ->add(new MatchedDeclensionDigit(85, 'восемьдесят пять'))
        ;

        $metadata = $this->factory->create($number, $collection, $currency);

        $this->assertEquals($metadata->getCurrency(), 'рублей');
        $this->assertEquals($metadata->getString(), 'одиннадцать тысяч восемьдесят пять');
        $this->assertEquals($metadata->getValue(), 11085);
    }

    public function testZeroFactory()
    {
        $collection = new MatchedDeclensionDigitCollection();
        $collection->add(new MatchedDeclensionDigit(0, 'ноль'));

        $metadata = $this->factory->create(
            0, $collection, new Declension('рубль', 'рубля', 'рублей', Declension::GENDER_M)
        );

        $this->assertEquals($metadata->getValue(), 0);
        $this->assertEquals($metadata->getString(), 'ноль');
        $this->assertEquals($metadata->getCurrency(), 'рублей');
    }

    public function testCombineMatchedDeclensionDigitCollection()
    {
        $collection = new MatchedDeclensionDigitCollection();

        $collection
            ->add(new MatchedDeclensionDigit(262, 'двести шестьдесят два', 'миллиона'))
            ->add(new MatchedDeclensionDigit(0, 'ноль', 'тысяч'))
            ->add(new MatchedDeclensionDigit(1, 'один', ''))
        ;

        $result = $this->factory->combineMatchedDeclensionDigitCollection($collection);

        $this->assertEquals(
            'двести шестьдесят два миллиона один',
            $result
        );

        $collection = new MatchedDeclensionDigitCollection();

        $collection
            ->add(new MatchedDeclensionDigit(31, 'тридцать один', 'миллиард'))
            ->add(new MatchedDeclensionDigit(289, 'двести восемдесят девять', 'миллонов'))
            ->add(new MatchedDeclensionDigit(8, 'восемь', 'тысяч'))
            ->add(new MatchedDeclensionDigit(11, 'одиннадцать', ''))
        ;

        $result = $this->factory->combineMatchedDeclensionDigitCollection($collection);

        $this->assertEquals(
            'тридцать один миллиард двести восемдесят девять миллонов восемь тысяч одиннадцать',
            $result
        );
    }
}
