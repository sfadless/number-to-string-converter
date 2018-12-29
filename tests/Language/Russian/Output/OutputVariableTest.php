<?php
/**
 * OutputVariableTest
 *
 * @author Pavel Golikov <pgolikov327@gmail.com>
 */

namespace Sfadless\NumberToStringConverter\Tests\Language\Russian\Output;

use Sfadless\NumberToStringConverter\Language\Russian\Output\Output;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputMetadata;
use Sfadless\NumberToStringConverter\Language\Russian\Output\OutputVariable;
use PHPUnit\Framework\TestCase;

class OutputVariableTest extends TestCase
{
    /**
     * @var Output
     */
    private $output;

    public function setUp()
    {
        $this->output = new Output(
            new OutputMetadata(123, 'сто двадцать три', 'рубля'),
            new OutputMetadata(89, 'восемьдесят девять', 'копеек'),
            '%i_value%'
        );
    }

    public function testHandle()
    {
        $var1 = new OutputVariable('i_value', function (Output $output) {
            return $output->getInteger()->getString();
        });

        $this->assertEquals('сто двадцать три', $var1->handle($this->output));
    }
}
