<?php

namespace Sfadless\NumberToStringConverter\Language\Russian\Output;

/**
 * Output
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */
class Output
{
    const DEFAULT_TEMPLATE = '%i_string% %i_currency% %f_string% %f_currency%';

    /**
     * @var OutputMetadata
     */
    private $integer;

    /**
     * @var OutputMetadata
     */
    private $fractional;

    /**
     * @var string
     */
    private $template;

    /**
     * @var OutputVariable[]
     */
    private $variables;

    /**
     * @return OutputMetadata
     */
    public function getInteger()
    {
        return $this->integer;
    }

    /**
     * @return OutputMetadata
     */
    public function getFractional()
    {
        return $this->fractional;
    }

    /**
     * Output constructor.
     * @param OutputMetadata $integer
     * @param OutputMetadata $fractional
     * @param string $template
     */
    public function __construct(OutputMetadata $integer, OutputMetadata $fractional, $template = Output::DEFAULT_TEMPLATE)
    {
        $this->integer = $integer;
        $this->fractional = $fractional;
        $this->template = $template;
        $this->variables = $this->getDefaultVariables();
    }

    /**
     * @param OutputVariable $variable
     * @return $this
     */
    public function addVariable(OutputVariable $variable)
    {
        $this->variables[] = $variable;

        return $this;
    }

    /**
     * @return string
     */
    public function output()
    {
        $output = $this->template;

        foreach ($this->variables as $variable) {
            $need = '%' . $variable->getName() . '%';

            if (mb_strpos($output, $need) === false) {
                continue;
            }

            $output = str_replace($need, $variable->handle($this), $output);
        }

        return $output;
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return OutputVariable[]
     */
    private function getDefaultVariables()
    {
        return [
            new OutputVariable('i_value', function (Output $output) { return $output->getInteger()->getValue(); }),
            new OutputVariable('i_string', function (Output $output) { return $output->getInteger()->getString(); }),
            new OutputVariable('i_currency', function (Output $output) { return $output->getInteger()->getCurrency(); }),
            new OutputVariable('f_value', function (Output $output) { return $output->getFractional()->getValue(); }),
            new OutputVariable('f_string', function (Output $output) { return $output->getFractional()->getString(); }),
            new OutputVariable('f_currency', function (Output $output) { return $output->getFractional()->getCurrency(); }),
        ];
    }
}