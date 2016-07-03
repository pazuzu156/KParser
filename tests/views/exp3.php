<?php

require __DIR__ . '/../../vendor/autoload.php'; // Require the autoloading file from Composer

use Pazuzu156\KParser\KParser; // Use the KParser class from the Pazuzu156\KParser package

$content = <<<EOF
[hr type=hrclass]
<h2>Terminal</h2>
Terminal Output:[nl]
[terminal user=root host=kalebklein.com]
[command]ls -l[/command]
[command]clear[/command]
[command]which sh[/command]
[response]/usr/bin/sh[/response]
[/terminal]
EOF;

$parser = new KParser;
echo $parser->parse($content);
