<?php

require __DIR__ . '/../vendor/autoload.php'; // Require the autoloading file from Composer

use Pazuzu156\KParser\KParser; // Use the KParser class from the Pazuzu156\KParser package

$text = "[h1]Heading 1[/h1]";
$text .= "[h6]Heading 6[/h6]";
$text .= "[p]My Paragraph[/p]";
$text .= "[b]Bold Text[/b][nl]";
$text .= "[i]Italic Text[/i][nl]";
$text .= "Image: [img src=http://cdn.kalebklein.com/images/forum_sig.png][nl]";
$text .= "Class Image: [img src=http://cdn.kalebklein.com/images/forum_sig.png class=gallery][nl]";
$text .= "Sized Image w/both | 450x90: [img src=http://cdn.kalebklein.com/images/forum_sig.png size=450x90][nl]";
$text .= "Sized Image w/ single | 450: [img src=http://cdn.kalebklein.com/images/forum_sig.png size=450][nl]";
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
$text .= "[size=20px]20px Sized Text[/size][nl]";
$text .= "[color=red]Red Text[/color][nl]";
$text .= "[color=#00ff00]Green Text[/color][nl]";
$text .= "[center]Centered Text[/center][nl]";
$text .= "[quote]Quote from unknown source. So citation left out[/quote]";
$text .= "[quote=Wikipedia]A quote from a known source. Source cited in code[/quote]";
$text .= "[url=http://www.kalebklein.com]My Website[/url] - Link with URL[nl]";
$text .= "[url=http://www.google.com newtab]Google[/url] - Link with URL that opens in a new tab[nl]";
$text .= "[url]http://www.facebook.com[/url] - Unnamed URL[nl]";
$text .= "Word[space]1 space[space4]4 spaces[nl]";
$text .= "Word[tab]Single tab[tab4]4 tabs[nl]";
$text .= "Command:[nl][cmd]nano /etc/pacman.d/mirrorlist[/cmd][nl]";

$text .= "[code=cpp]#include <iostream>

using namespace std;

int main()
{
	cout << \"Hello World!\";
	cin.get();

	return 0;
}[/code]";
$text .= "Youtube Video: [youtube url=https://www.youtube.com/watch?v=g4rYh3e97VU][nl]";

$text .= "HTML5 Video:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4][nl]";

$text .= "HTML5 Video with controls:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4 controls][nl]";

$text .= "HTML5 Video with width & height size:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4 controls size=500x400][nl]";

$text .= "HTML5 Video with global size:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4 size=500][nl]";

$text .= "[hr type=hrclass]";
$text .= "<h2>Emoticons</h2>";

$parser = new KParser;
echo $parser->parse($text);
