# NumberToStringConverter

Converts numbers to strings

## Documentation

### Basic usage
```php
use Sfadless\NumberToStringConverter\Language\Russian\RussianLanguageFactory;
use Sfadless\NumberToStringConverter\NumberToStringConverter;

$factory = new RussianLanguageFactory();
$russianLanguage = $factory->create();

$converter = new NumberToStringConverter($russianLanguage);

$converter->convert(33.27); //тридцать три рубля двадцать семь копеек
```

### Output templates
You can control output with templates. Default template is "%i_string% %i_currency% %f_string% %f_currency%". It means, 
that for number 11.12 default output will be "одиннадцать рублей двенадцать копеек".
Available variables in template by default are %i_string%, %i_value%, %i_currency%, %f_string%, %f_value%, %f_currency%.
```php
$template = '%i_value% %i_currency% %f_value% %f_currency%';
$converter->convert(12.22, ['template' => $template]); // 12 рублей 22 копейки
```

### Adding variables in templates
If you need, you can add your own variables in template, where you have full control of output.
```php
use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputVariable;

$variable = new OutputVariable('i_short_curency', function (Output $output) {
    return mb_substr($output->getInteger()->getCurrency(), 0, 3);
});

$template = '%i_value% %i_short_curency%';

$converter->convert(12, ['template' => $template, 'variables' => [$variable]]); // 12 руб
```

### Change currency
By default, currency is rubles. You can create any currency you like.

```php
use Sfadless\NumberToStringConverter\Language\Russian\Currency;
use Sfadless\NumberToStringConverter\Language\Russian\Declension\Declension;

$currency = new Currency(
    new Declension('доллар', 'доллара', 'долларов', Declension::GENDER_M),
    new Declension('цент', 'цента', 'центов', Declension::GENDER_M)
);

$converter->convert(3.05, ['currency' => $currency]); //три доллара пять центов
```