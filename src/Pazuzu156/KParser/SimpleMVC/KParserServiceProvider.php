<?php namespace Pazuzu156\KParser\SimpleMVC;

use SimpleMVC\Support\ServiceProvider;

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