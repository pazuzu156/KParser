<?php namespace Pazuzu156\KParser\Scara;

use Scara\Support\ServiceProvider;

use Pazuzu156\KParser\KParser;

class KParserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->create('kparser', function()
        {
            return new KParser;
        });
    }
}