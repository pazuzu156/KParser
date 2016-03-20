<?php

require __DIR__ . '/../../vendor/autoload.php'; // Require the autoloading file from Composer

use Pazuzu156\KParser\KParser; // Use the KParser class from the Pazuzu156\KParser package

$parser = new KParser;

$emotearray = array(
	":angry:",
	":arrow:",
	":bigsmile:",
	":blink:",
	":cool:",
	":dunno:",
	":!:",
	":omg:",
	":laugh:",
	":ohmy:",
	":ninja:",
	":puke:",
	":??:",
	":we:",
	":frown:",
	":smile:",
	":tongue:",
	":123:",
	":wink:"
);

echo "<tr>\n";

foreach($emotearray as $emote)
{
	echo "<th style='border: 1px inset #000;'>\n\t" . $emote . "\n</th>\n";
}

echo "</tr>\n<tr>\n";

foreach($emotearray as $emote)
{
	echo "<td style='border: 1px inset #000;'>\n\t" . $parser->parse($emote, true) . "\n</td>" . "\n";
}

echo "</tr>\n";

?>
</table>
<br><br>
