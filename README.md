# KParser
A simple parsing tool for my website

## About
KParser is a parsing tool for my website. It's got BBCode, some of my own variants of it, and syntax highlighting support with GeSHi

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
