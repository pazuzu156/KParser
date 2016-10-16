<?php

namespace Pazuzu156\KParser\Scara;

use Pazuzu156\KParser\KParser;
use Scara\Support\Facades\Facade;

class KParserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kparser';
    }
}
