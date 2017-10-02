# NumberToStringConverter

Converts numbers to strings

## Documentation
```php
use Sfadless\Utils\Converter\NumberToStringConverter;

$converter = new NumberToStringConverter();

$converter->convert(12.61); //двенадцать рублей шестьдесят одна копейка

$converter->convert(123, ['withoutCurrency' => true]); //сто двадцать три

$converter->convert(33.54, ['floatAsNumber' => true]); //тридцать три рубля 54 копейки
```
#### Advantage usage

If you want to use your own units, you should create it as currency, and pass to it CaseEntity, witch
describes Currency cases.
```php
new CaseEntity(array $case, string $gender);
```
If CaseEntity has female gender, you should pass 'f' as second argument.

##### Example
```php
use Sfadless\Utils\Converter\Currency\CaseEntity;
use Sfadless\Utils\Converter\Currency\Currency;
use Sfadless\Utils\Converter\NumberToStringConverter;

$currency = new Currency(
    new CaseEntity(['доллар', 'долларов', 'доллара']),
    new CaseEntity(['цент', 'центов', 'цента'])
);

$converter = new NumberToStringConverter($currency);

$converter->convert(2245.39); //две тысячи двести сорок пять долларов тридцать девять центов
```
##### With female gender
```php
$currency = new Currency(
    new CaseEntity(['целая', 'целых', 'целые'], 'f'),
    new CaseEntity(['десятая', 'десятых', 'десятые'], 'f')
);

$converter = new NumberToStringConverter($currency);

$converter->convert(21.31); //двадцать одна целая тридцать одна десятая
```