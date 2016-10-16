<?php

use Pazuzu156\KParser\KParser;

class ParsingTest extends PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $parser = new KParser();
        $this->assertTrue($parser->parse('Testing parsing method') !== '');
    }
}
