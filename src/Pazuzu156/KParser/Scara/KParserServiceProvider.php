<?php

namespace Pazuzu156\KParser\Scara;

use Pazuzu156\KParser\KParser;
use Scara\Config\Configuration;
use Scara\Support\ServiceProvider;

class KParserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->create('kparser', function () {
            $cc = new Configuration();
            $render = $cc->from('kparser')->get('render_code');

            return new KParser($render);
        });
    }
}
