# KParser
[![Build Status](https://travis-ci.org/pazuzu156/KParser.svg?branch=master)](https://travis-ci.org/pazuzu156/KParser)
[![Latest Stable Version](https://poser.pugx.org/pazuzu156/kparser/v/stable)](https://packagist.org/packages/pazuzu156/kparser)
[![Total Downloads](https://poser.pugx.org/pazuzu156/kparser/downloads)](https://packagist.org/packages/pazuzu156/kparser)
[![Latest Unstable Version](https://poser.pugx.org/pazuzu156/kparser/v/unstable)](https://packagist.org/packages/pazuzu156/kparser)
[![License](https://poser.pugx.org/pazuzu156/kparser/license)](https://packagist.org/packages/pazuzu156/kparser)

A simple parsing tool for my website.

## About
KParser is a parsing tool for my website. It's got BBCode, some of my own variants of it, and syntax highlighting support with GeSHi

## Supported Tags
```
[p]Paragraph Tag[/p]  
[b]Bold Text Tag[/p]  
[i]Italicized Tag[/i]  
[u]Underlined Text Tag[/u]  
[s]Strikethrough Text Tag[/s]  
[o]Overlined Text Tag[/o]  
[hr] - Horizonal Rule Tag  
[hr type=classname] - Horizonal Rule Tag with custom class  
[ul]Unordered List[/ul]  
[ol]Ordered List[/ol]  
[li]List Item Tag - Place inside ordered or unordered list tags[/li]  
[code=language]Code Block Tag[/code] - Code block is tied in with GeSHi; the syntax highlighter for PHP. GeSHi is required to use KParser because of this  
[youtube url=YOUTUBE_VIDEO_URL] - Uses full or share link for YouTube videos  
[size=SIZE]Sized text based on SIZE[/size]
[color=COLOR]Colored text based on COLOR. Can be real value or HEX (red OR #ff0000)[/color]
[center]Centered Text[/center]
[quote]Quoted text with no source cited[/quote]
[quote=Quoted Dude]Quoted text with source cited[/quote]
[url]Unnamed URL[/url]
[url=http://example.com]Named URL[/url]
[url=http://example.com newtab]Named URL that opens in a new tab[/url]
[img src=http://example.com/images/image.jpg] Image
[img src=http://example.com/images/image.jpg class=img-class] Image with class
[img src=http://example.com/images/image.jpg size=150] Sized image defining width
[img src=http://example.com/images/image.jpg size=150x100] Sized image defining width and height
[video src=http://example.com/videos/video.mp4] HTML5 video
[video src=http://example.com/videos/video.mp4 controls] HTML5 video with controls
[video src=http://example.com/videos/video.mp4 size=500x400] HTML5 video with width and height
[video src=http://example.com/videos/video.mp4 size=500] HTML5 video with global size
[video src=http://example.com/videos/video.mp4 controls size=500] HTML5 video with global size and controls
[hNUMBER] Heading. 1-6 for NUMBER[/hNUMBER]
[space] A single space
[spaceNUMBER] A NUMBER of spaces
[tab] A single tab
[tabNUMBER] A NUMBER of tabs
[cmd] Command line command[/cmd] - Shows a command block using <pre> and <code>
[noparse] Place KScript code in here[/noparse] - Prevents KScript from being parsed inside this block 
[cmt=COMMENT] Write a comment in your code to yourself ;)  
```


## Install
To install this into Laravel, include the following in your composer.json:  
```
"pazuzu156/kparser": "1.*",
```

If you wish to use the lastest "bleeding-edge" version of KParser, use the following instead of the official release:  
```
"pazuzu156/kparser": "dev-master"
```

Or..just use composer ;) `$ composer require pazuzu156/kparser`

Once you've done that, include the service provider and facade into app/config/app.php  
<u>Service Provider</u>  
```php
Pazuzu156\KParser\Laravel\KParserServiceProvider::class
```
<u>Facade</u>
```php
'KParser' => Pazuzu156\KParser\Laravel\KParserFacade::class
```

## Usage
To use KParser, you can either include it into the php file or use the facade to integrate it into Blade using the service provider/facade included.
```php
<?php
use Pazuzu156\KParser\KParser;

class MyController extends Controller
{
    public function controllerFunction($text)
    {
    	$p = new KParser;
        return $p->parse($text);
    }
}

```

```blade
@extends('layout.main')
@section('content')
{!! KParser::parse('[code=php]<?php echo "Hello World!"; ?>[/code]') !!}
@stop
```

## Support
KParser has support for the popular Laravel framework as well as support for my own MVC framework [Scara](https://github.com/ScaraMVC/Scara)
