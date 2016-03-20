<?php namespace Pazuzu156\KParser\SimpleMVC;

use SimpleMVC\Support\Facades\Facade;
use Pazuzu156\KParser\KParser;

class KParserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kparser';
    }
}