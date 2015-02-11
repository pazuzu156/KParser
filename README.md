# KParser
A simple parsing tool for my website

## About
KParser is a parsing tool for my website. It's got BBCode, some of my own variants of it, and syntax highlighting support with GeSHi

## Supported Tags
````
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
[img src=http://example.com/images/image.jpg size=150] Sized image defining width
[img src=http://example.com/images/image.jpg size=150x100] Sized image defining width and height
[video src=http://example.com/videos/video.mp4] HTML5 video
[video src=http://example.com/videos/video.mp4 controls] HTML5 video with controls
[video src=http://example.com/videos/video.mp4 size=500x400] HTML5 video with width and height
[video src=http://example.com/videos/video.mp4 size=500] HTML5 video with global size
[video src=http://example.com/videos/video.mp4 controls size=500] HTML5 video with global size and controls
```


## Install
To install this into Laravel, include the following in your composer.json:  
```
"kalebklein/kparser": "1.0.*",
"geshi/geshi": "dev-master"
```

If you wish to use the lastest "bleeding-edge" version of KParser, use the following instead of the official release:  
```
"kalebklein/kparser": "dev-master"
```

Once you've done that, include the service provider and facade into app/config/app.php  
<u>Service Provider</u>  
```php
'KalebKlein\KParser\KParserServiceProvider'
```
<u>Facade</u>
```php
'KParser' => 'KalebKlein\KParser\Facades\KParserFacade'
```

## Usage
To use KParser, you can either include it into the php file or use the facade to integrate it into Blade. The facade is also extended into class usage itself, as demonstrated below
```php
<?php
use KalebKlein\KParser\KParser;

class MyController extends Controller
{
    public function controllerFunction($text)
    {
        return KParser::parse($text);
    }
}

```

```php
@extends('layout.main')
@section('content')
{{ KParser::parse([code=php]<?php echo "Hello World!"; ?>[/code]) }}
@stop
```
