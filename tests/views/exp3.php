<?php

require __DIR__.'/../../vendor/autoload.php'; // Require the autoloading file from Composer

use Pazuzu156\KParser\KParser; // Use the KParser class from the Pazuzu156\KParser package

$content = <<<'EOF'
[hr type=hrclass]
<h2>Terminal</h2>
Terminal Output:[nl]
[terminal user=root host=kalebklein.com]
[command]ls -l[/command]
[command]clear[/command]
[command]which sh[/command]
[response]/usr/bin/sh[/response]
[/terminal]
[p]Supported themes:
[ol]
[li]Default ^ The one you see here[/li]
[li]KParser[/li]
[li]Solarized[/li]
[li]Solarized Dark[/li]
[li]Coffee[/li]
[li]Monokai[/li]
[li]Predawn[/li]
[li]Bluebird[/li]
[/ol]
You can view the different themes supported by the Terminal widget by using the [url=http://testsites.kalebklein.com/terminal/ newtab]KParser Terminal Style Tester Tool[/url][/p]
EOF;

$parser = new KParser();
echo $parser->parse($content);
