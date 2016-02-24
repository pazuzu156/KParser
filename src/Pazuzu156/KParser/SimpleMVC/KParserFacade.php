<?php namespace Pazuzu156\KParser\SimpleMVC;

use Pazuzu156\KParser\KParser;

class KParserFacade
{
    /**
     * Alias's instance
     *
     * @var \Pazuzu156\KParser\KParser
     */
    private static $instance;

    /**
     * Boot sequence for alias
     *
     * @return void
     */
    public static function boot()
    {
        self::$instance = new KParser;
    }

    /**
     * Parse content
     *
     * @param string $string
     * @return string
     */
    public static function parse($string)
    {
        return self::$instance->parse($string);
    }
}