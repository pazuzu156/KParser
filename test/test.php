<?php

/**
 * test.php
 *
 * PHP File that tests each tag built in to KParser
 */

require __DIR__ . '/../vendor/autoload.php'; // Require the autoloading file from Composer

use KalebKlein\KParser\KParser; // Use the KParser class from the KalebKlein\KParser package

?>

<!-- Style for custom hr and codeblock -->
<style type="text/css">
hr.hrclass
{
	height: 5px;
	border: none;
	background-color: #ccc;
	border-radius: 2px;
	margin: 25px 0;
}

.codeBlock {
	background:#dae4ed;
	border:1px solid #0D8EFF;
	color:#000;
	padding:5px;
	font-family: monospace;
	overflow: auto;
	font-size: 12px;
	max-height: 300px;
}
.codeBlockHeader {
	color: green;
	margin-bottom: -15px;
	font-weight: bold;
	padding: 10px 10px;
}
</style>

<?php

$text = "[p]My Paragraph[/p]";
$text .= "[b]Bold Text[/b][nl]";
$text .= "[i]Italic Text[/i][nl]";
$text .= "Image: [img src=http://www.kalebklein.com/images/kk-icon.png][nl]";
$text .= "[u]Underlined Text[/u][nl]";
$text .= "[s]Strike Through Text[/s][nl]";
$text .= "[o]Overlined Text[/o][nl]";
$text .= "Horizontal Rule: [hr]";
$text .= "Horizontal Rule With Style: [hr type=hrclass]";
$text .= "Unordered List: [ul][nl]";
$text .= "[li]List Item 1[/li]";
$text .= "[li]List Item 2[/li]";
$text .= "[li]List Item 3[/li][/ul]";
$text .= "Ordered List: [ol][nl]";
$text .= "[li]List Item 1[/li]";
$text .= "[li]List Item 2[/li]";
$text .= "[li]List Item 3[/li][/ol]";
$text .= "[size=20]20px Sized Text[/size][nl]";
$text .= "[color=red]Red Text[/color][nl]";
$text .= "[color=#00ff00]Green Text[/color][nl]";
$text .= "[center]Centered Text[/center][nl]";
$text .= "[quote]Quote from unknown source. So citation left out[/quote]";
$text .= "[quote=Wikipedia]A quote from a known source. Source cited in code[/quote]";
$text .= "[url=http://www.kalebklein.com]My Website[/url] - Link with URL[nl]";
$text .= "[url=http://www.google.com newtab]Google[/url] - Link with URL that opens in a new tab[nl]";
$text .= "[url]http://www.facebook.com[/url] - Unnamed URL[nl]";

$text .= "[code=cpp]#include \"<iostream>\"

using namespace std;

int main()
{
	cout << \"Hello World!\";
	cin.get();

	return 0;
}[/code]";
$text .= "Video: [youtube url=https://www.youtube.com/watch?v=g4rYh3e97VU]";

$text .= "[hr type=hrclass]";
$text .= "<h2>Emoticons</h2>";

echo KParser::parse($text);

?>

<table style="text-align: center; border: 1px outset #000">

<?php

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
	echo "<td style='border: 1px inset #000;'>\n\t" . KParser::parse($emote, true) . "\n</td>" . "\n";
}

echo "</tr>\n";

?>
</table>
