<?php

require __DIR__ . '/../vendor/autoload.php';

use KalebKlein\KParser\KParser;

?>

<style type="text/css">
hr.hrclass
{
	height: 5px;
	border: none;
	background-color: #ccc;
	border-radius: 2px;
	margin: 25px 0;
}
</style>

<?php

$text = "[p]My Paragraph[/p]";
$text .= "[b]Bold Text[/b][nl]";
$text .= "[i]Italic Text[/i][nl]";
$text .= "Image: [img src=http://www.kalebklein.com/images/kk-icon.png][nl]";
$text .= "[u]Underlined Text[/u][nl]";
$text .= "[strike]Strike Through Text[/strike][nl]";
$text .= "[over]Overlined Text[/over][nl]";
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
$text .= "[code=cpp]#include \"<iostream>\"

using namespace std;

int main()
{
	cout << \"Hello World!\";
	cin.get();

	return 0;
}[/code]";
$text .= "Video: [ytvid url=https://www.youtube.com/watch?v=g4rYh3e97VU]";

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
	echo "<th style='border: 1px inset #000;'>" . $emote . "</th>\n";
}

echo "</tr>\n<tr>\n";

foreach($emotearray as $emote)
{
	echo KParser::parse("<td style='border: 1px inset #000;'>" . $emote . "</td>", true);
}

echo "</tr>\n";

?>
</table>
