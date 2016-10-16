<?php

require __DIR__.'/../../vendor/autoload.php'; // Require the autoloading file from Composer

use Pazuzu156\KParser\KParser; // Use the KParser class from the Pazuzu156\KParser package

$text = <<<EOF
[h1]Heading 1[/h1]
[h6]Heading 6[/h6]
[p]My Paragraph[/p]
[b]Bold Text[/b][nl]
[i]Italic Text[/i][nl]
Image: [img src=http://cdn.kalebklein.com/images/forum_sig.png][nl]
Class Image: [img src=http://cdn.kalebklein.com/images/forum_sig.png class=gallery][nl]
Sized Image w/both | 450x90: [img src=http://cdn.kalebklein.com/images/forum_sig.png size=450x90][nl]
Sized Image w/ single | 450: [img src=http://cdn.kalebklein.com/images/forum_sig.png size=450][nl]
[u]Underlined Text[/u][nl]
[s]Strike Through Text[/s][nl]
[o]Overlined Text[/o][nl]
Horizontal Rule: [hr]
Horizontal Rule With Style: [hr type=hrclass]
Unordered List: [ul][nl]
[li]List Item 1[/li]
[li]List Item 2[/li]
[li]List Item 3[/li][/ul]
Ordered List: [ol][nl]
[li]List Item 1[/li]
[li]List Item 2[/li]
[li]List Item 3[/li][/ol]
[size=20px]20px Sized Text[/size][nl]
[color=red]Red Text[/color][nl]
[color=#00ff00]Green Text[/color][nl]
[center]Centered Text[/center][nl]
[quote]Quote from unknown source. So citation left out[/quote]
[quote=Wikipedia]A quote from a known source. Source cited in code[/quote]
[url=http://www.kalebklein.com]My Website[/url] - Link with URL[nl]
[url=http://www.google.com newtab]Google[/url] - Link with URL that opens in a new tab[nl]
[url]http://www.facebook.com[/url] - Unnamed URL[nl]
Word[space]1 space[space4]4 spaces[nl]
Word[tab]Single tab[tab4]4 tabs[nl]
Command:[nl][cmd]nano /etc/pacman.d/mirrorlist[/cmd][nl]

[nl][nl]Comment:[nl][cmt=This is a comment]You can't see it :). It looks like: [noparse][cmt=This is a comment][/noparse][nl][nl]

No Parse:[nl][noparse]
    [code=php]this is a code block[/code][nl]-newline[p]paragraph[/p]
[/noparse][nl][nl]

[code=cpp]#include <iostream>

using namespace std;

int main()
{
    cout << \"Hello World!\";
    cin.get();

    return 0;
}[/code]
Youtube Video: [youtube url=https://www.youtube.com/watch?v=g4rYh3e97VU][nl]

HTML5 Video:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4][nl]

HTML5 Video with controls:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4 controls][nl]

HTML5 Video with width & height size:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4 controls size=500x400][nl]

HTML5 Video with global size:[nl][video src=http://cdn.kalebklein.com/kparser/video.mp4 size=500][nl]

[hr type=hrclass]
<h2>Emoticons</h2>
EOF;

$parser = new KParser();
echo $parser->parse($text);
