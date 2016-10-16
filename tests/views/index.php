<?php

require __DIR__.'/../../vendor/autoload.php'; // Require the autoloading file from Composer

use Pazuzu156\KParser\KParser; // Use the KParser class from the Pazuzu156\KParser package

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KScript Examples</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/simplex/bootstrap.min.css">
    <style type="text/css">
        hr.hrclass
        {
            height: 5px;
            border: none;
            background-color: #ccc;
            border-radius: 2px;
            margin: 25px 0;
        }
        .codeBlock
        {
            background: #dae4ed;
            border: 1px solid #0D8EFF;
            color: #000;
            padding: 5px;
            font-family: monospace;
            overflow: auto;
            font-size: 12px;
            max-height: 300px;
        }

        .codeBlockHeader
        {
            color: green;
            margin-bottom: -15px;
            font-weight: bold;
            padding: 10px 10px;
            background: url('http://cdn.kalebklein.com/kparser/img/cbh.png');
        }
        .navbar-inverse {
            border-radius: 0;
        }
    </style>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
    <a href="https://github.com/pazuzu156/KParser"><img style="position: absolute; top: 0; right: 0; border: 0; z-index: 9999;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png"></a>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">KScript Examples</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" data-toggle="modal" data-target="#aboutModal">About</a></li>
            <li><a href="http://kalebklein.com" target="_blank">My Website</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Extra <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="https://github.com/pazuzu156/KParser" target="_blank">Fork on GitHub</a></li>
                    <li><a href="https://packagist.org/packages/pazuzu156/kparser" target="_blank">View on Packagist</a></li>
                </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<div class="container">
    <div class="panel panel-warning">
        <div class="panel-heading">
            All Supported Tags
        </div>
        <div class="panel-body">
            [p]Paragraph Tag[/p]<br>
            [b]Bold Text Tag[/p]<br>
            [i]Italicized Tag[/i]<br>
            [u]Underlined Text Tag[/u]<br>
            [s]Strikethrough Text Tag[/s]<br>
            [o]Overlined Text Tag[/o]<br>
            [hr] - Horizonal Rule Tag<br>
            [hr type=classname] - Horizonal Rule Tag with custom class<br>
            [ul]Unordered List[/ul]<br>
            [ol]Ordered List[/ol]<br>
            [li]List Item Tag - Place inside ordered or unordered list tags[/li]<br>
            [code=language]Code Block Tag[/code] - Code block is tied in with GeSHi; the syntax highlighter for PHP. GeSHi is required to use KParser because of this<br>
            [youtube url=YOUTUBE_VIDEO_URL] - Uses full or share link for YouTube videos<br>
            [size=SIZE]Sized text based on SIZE[/size]<br>
            [color=COLOR]Colored text based on COLOR. Can be real value or HEX (red OR #ff0000)[/color]<br>
            [center]Centered Text[/center]<br>
            [quote]Quoted text with no source cited[/quote]<br>
            [quote=Quoted Dude]Quoted text with source cited[/quote]<br>
            [url]Unnamed URL[/url]<br>
            [url=http://example.com]Named URL[/url]<br>
            [url=http://example.com newtab]Named URL that opens in a new tab[/url]<br>
            [img src=http://example.com/images/image.jpg] Image<br>
            [img src=http://example.com/images/image.jpg class=img-class] Image with class<br>
            [img src=http://example.com/images/image.jpg size=150] Sized image defining width<br>
            [img src=http://example.com/images/image.jpg size=150x100] Sized image defining width and height<br>
            [video src=http://example.com/videos/video.mp4] HTML5 video<br>
            [video src=http://example.com/videos/video.mp4 controls] HTML5 video with controls<br>
            [video src=http://example.com/videos/video.mp4 size=500x400] HTML5 video with width and height<br>
            [video src=http://example.com/videos/video.mp4 size=500] HTML5 video with global size<br>
            [video src=http://example.com/videos/video.mp4 controls size=500] HTML5 video with global size and controls<br>
            [hNUMBER]Heading. 1-6 for NUMBER[/hNUMBER]<br>
            [space]A single space<br>
            [spaceNUMBER]A NUMBER of spaces<br>
            [tab]A single tab<br>
            [tabNUMBER]A NUMBER of tabs<br>
            [cmd]Command line command[/cmd] - Shows a command block using &lt;pre&gt; and &lt;code&gt;<br>
            [noparse]Place KScript code in here[/noparse] - Prevents KScript from being parsed inside this block<br>
            [cmt=COMMENT]Write a comment in your code to yourself ;)<br>
            [terminal user=root host=kalebklein.com][command]A command[/command][response]Response to a command[/response][/terminal]<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you wish to display a terminal window with cool styling, use this one. :)<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An option theme attribute is also there, if you wish to select a theme for the widget. Ex: theme=solarized
        </div>
    </div>
    <hr class="hrclass">
    <h1>All Tags in Action</h1>
    <?php require_once 'exp3.php'; ?>
    <?php require_once 'exp1.php'; ?>
    <table style="text-align: center; border: 1px outset #000">

    <?php require_once 'exp2.php'; ?>
    
</div>
<div class="modal fade" id="aboutModal" role="dialog" aria-labeledby="aboutModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="aboutModalLabel">About KParser &amp; KScript</h4>
            </div>
            <div class="modal-body">
                KParser is a PHP class that parses KScript, the page content script I use for my website.<br><br>
                KParser is compatible with both Laravel 4 and Laravel 5, so integrating KParser into Laravel is quite simple.<br><br>
                Be sure to <a href="https://github.com/pazuzu156/KParser" target="_blank">fork the project</a> and check out KParser on <a href="https://packagist.org/packages/pazuzu156/kparser" target="_blank">Packagist</a> for getting KParser via Composer
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
