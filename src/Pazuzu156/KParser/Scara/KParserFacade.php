<?php

namespace Pazuzu156\KParser\Scara;

use Scara\Support\Facades\Facade;
use Pazuzu156\KParser\KParser;

class KParserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kparser';
    }
}
