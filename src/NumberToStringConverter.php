<?php

namespace Sfadless\NumberToStringConverter;

use Sfadless\NumberToStringConverter\Exception\LanguageByCodeNotFoundException;
use Sfadless\NumberToStringConverter\Language\LanguageInterface;

/**
 * NumberToStringConverter
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class NumberToStringConverter
{
    /**
     * @var LanguageInterface[]
     */
    private $languages;

    /**
     * @var LanguageInterface
     */
    private $defaultLanguage;

    /**
     * @param $number
     * @param array $options
     * @param null $languageCode
     * @return string
     * @throws LanguageByCodeNotFoundException
     */
    public function convert($number, array $options = [], $languageCode = null)
    {
        if (null === $languageCode) {
            $language = $this->defaultLanguage;
        } else {
            if (! isset($this->languages[$languageCode])) {
                throw new LanguageByCodeNotFoundException(sprintf("Language by code %s not registered", $languageCode));
            }

            $language = $this->languages[$languageCode];
        }

        return $language->convert($number, $options);
    }

    /**
     * @param LanguageInterface $language
     */
    public function addLanguage(LanguageInterface $language)
    {
        $this->languages[$language->getCode()] = $language;
    }

    /**
     * NumberToStringConverter constructor.
     * @param LanguageInterface $language
     */
    public function __construct(LanguageInterface $language)
    {
        $this->addLanguage($language);
        $this->defaultLanguage = $language;
    }
}