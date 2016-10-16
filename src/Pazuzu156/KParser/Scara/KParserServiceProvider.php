<?php

namespace Pazuzu156\KParser\Scara;

use Scara\Support\ServiceProvider;
use Scara\Config\Configuration;
use Pazuzu156\KParser\KParser;

class KParserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->create('kparser', function()
        {
            $cc = new Configuration;
            $render = $cc->from('kparser')->get('render_code');
            return new KParser($render);
        });
    }
}
