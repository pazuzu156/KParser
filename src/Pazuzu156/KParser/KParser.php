<?php

namespace Pazuzu156\KParser;

/**
 * Class KParser.
 *
 * Parsing class for parsing supported tags into HTML. For use in blogs and such. Or whatever you want it
 * to be used for. :)
 *
 * @copyright 2014-2016 Kaleb Klein
 * @author Kaleb Klein <klein.jae@gmail.com>
 *
 * @version 1.2.3
 */
class KParser
{
    /**
     * Whether or not to render code block with GeSHI.
     *
     * @var bool
     */
    private $_renderCode;

    /**
     * Class constructor.
     *
     * @param bool $renderCode
     *
     * @return void
     */
    public function __construct($renderCode = true)
    {
        $this->_renderCode = $renderCode;
    }

    /**
     * parse - Parses all the different tags used in the page content.
     *
     * @param string $text      - The content to be parsed
     * @param bool   $comment   - Comment check. Certain tags are not parsed if set to true
     * @param bool   $striptags - Strips parsable tags from text. If you don't want anything parsed
     *
     * @return mixed - The parsed content returned
     */
    public function parse($text, $comment = false, $striptags = false)
    {
        /*
         * This is for the noparse tag
         *
         * This must be run first, so it removes any [] from the code, otherwise, something might
         * get parsed first before this can strip the brackets
         */
        $text = preg_replace_callback('/\[noparse\](.*?)\[\/noparse\]/sim', function ($matches) {
            $m = $matches[1];
            $m = preg_replace('/\[/i', '&#91;', $m);
            $m = preg_replace('/\]/i', '&#93;', $m);

            return $m;
        }, $text);

        /* Global patterns for code. Ones to always be parsed. Also the simplest patterns */
        $pattern[] = '/\[b\](.*?)\[\/b\]/i';
        $replace[] = '<strong>$1</strong>';
        $pattern[] = '/\[i\](.*?)\[\/i\]/i';
        $replace[] = '<em>$1</em>';
        $pattern[] = '/\[u\](.*?)\[\/u\]/i';
        $replace[] = '<span style="text-decoration: underline;">$1</span>';
        $pattern[] = '/\[s\](.*?)\[\/s\]/i';
        $replace[] = '<span style="text-decoration: line-through;">$1</span>';
        $pattern[] = '/\[o\](.*?)\[\/o\]/i';
        $replace[] = '<span style="text-decoration: overline;">$1</span>';
        $pattern[] = '/\[size=([0-9]+)(px|pt)\](.*?)\[\/size\]/i';
        $replace[] = '<span style="font-size: $1$2;">$3</span>';
        $pattern[] = '/\[color=(\#[a-fA-F0-9]+)\](.*?)\[\/color\]/i';
        $replace[] = '<span style="color: $1">$2</span>';
        $pattern[] = '/\[color=([a-zA-Z]+)\](.*?)\[\/color\]/i';
        $replace[] = '<span style="color: $1">$2</span>';
        $pattern[] = '/\[center\](.*?)\[\/center\]/i';
        $replace[] = '<div style="text-align: center;">$1</div>';
        $pattern[] = '/\[quote\](.*?)\[\/quote\]/i';
        $replace[] = '<blockquote>$1</blockquote>';
        $pattern[] = '/\[quote\=([a-zA-Z0-9\.\_\-\s]+)\](.*?)\[\/quote\]/i';
        $replace[] = '<blockquote cite="$1">$2<footer>Quoted: <cite title="$1">$1</cite></footer></blockquote>';
        $pattern[] = '/\[url\](.*?)\[\/url\]/i';
        $replace[] = '<a href="$1">$1</a>';
        $pattern[] = '/\[cmd\](.*?)\[\/cmd\]/i';
        $replace[] = '<pre><code>\$ $1</code></pre>';
        $pattern[] = '/\[cmt=(.*?)\]/i';
        $replace[] = '';

        /* This is for paragraph parsing. */
        $text = preg_replace_callback('#\[p\](.*)\[\/p\]#sU', function ($matches) {
            return '<p>'.$matches[1].'</p>';
        }, $text);

        /* This is for headings */
        $text = preg_replace_callback('#\[h([0-6])\](.*)\[\/h([0-6])\]#sU', function ($matches) {
            if ($matches[1] == $matches[3]) {
                return '<h'.$matches[1].'>'.$matches[2].'</h'.$matches[1].'>';
            }
        }, $text);

        /* Spaces */
        $text = preg_replace_callback('/\[space([0-9]{1,})?\]/i', function ($matches) {
            if (isset($matches[1])) {
                $r = '';
                for ($i = 0; $i < $matches[1]; $i++) {
                    $r .= '&nbsp;';
                }

                return $r;
            } else {
                return '&nbsp;';
            }
        }, $text);

        /* Tabs */
        $text = preg_replace_callback('/\[tab([0-9]{1,3})?\]/i', function ($matches) {
            $num = (isset($matches[1])) ? $matches[1] : 1;
            $tab = '';
            for ($i = 0; $i < $num; $i++) {
                $tab .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            }

            return $tab;
        }, $text);

        /* If it's a comment, then certain tags must not be rendered. Namely ones that edit the style of the page */
        if (!$comment) {
            $pattern[] = '#\[hr\]#sU';
            $replace[] = '<hr>';
            $pattern[] = '#\[hr\stype=([a-z_]+)]#sU';
            $replace[] = '<hr class="$1">';
            $pattern[] = '/\[ul\]/i';
            $replace[] = '<ul>';
            $pattern[] = '/\[\/ul\]/i';
            $replace[] = '</ul>';
            $pattern[] = '/\[ol\]/i';
            $replace[] = '<ol>';
            $pattern[] = '/\[\/ol\]/i';
            $replace[] = '</ol>';
            $pattern[] = '/\[li\]/i';
            $replace[] = '<li>';
            $pattern[] = '/\[\/li\]/i';
            $replace[] = '</li>';
            $pattern[] = '/\[nl\]/i';
            $replace[] = '<br>';

            /* The YouTube tag is a bit more tricky to parse. Since
             * the YouTube tag supports multiple ways to give a URL, each type
             * supplied needs to be rendered correctly
             */
            $text = preg_replace_callback('#\[youtube\surl=(.*)\]#sU', function ($matches) {
                $url = $matches[1];
                $e = explode('u.', $url);
                if (count($e) == 2) {
                    $exp = explode('/', $e[1]);
                    $videoID = $exp[1];
                } else {
                    $exp = explode('?v=', $url);
                    $videoID = $exp[1];
                }

                $s = '<iframe id="ytvid" class="ytvid" width="640" height="390" frameborder="0" '
                    .'src="https://cdn.kalebklein.com/kparser/loadytvid.php?videoID='
                    .$videoID.'"'
                    .' style="display: block; overflow: hidden; padding: 0;"'
                    .' scrolling="no">'
                    .'<p>Sorry, your browser doesn\'t support the iFrame element!</p></iframe>';

                return $s;
            }, $text);

            $text = preg_replace_callback('/\[video\ssrc=(.*?)(\scontrols)?(\ssize=([0-9]+)(x[0-9]+)?)?\]/i', function ($matches) {
                $s = '<video ';
                $s .= (isset($matches[4])) ? 'width="'.$matches[4].'" ' : '';
                if (isset($matches[5])) {
                    $s .= 'height="'.str_replace('x', '', $matches[5]).'"';
                }
                $s .= (isset($matches[2])) ? ' controls' : '';
                $s .= '>';
                $s .= "\n\t".'<source src="'.$matches[1].'" type="video/';
                $ext = explode('.', $matches[1]);
                $ext = array_reverse($ext);
                $s .= $ext[0];
                $s .= '">'."\n\t<p>Your browser does not support HTML5 video</p>";
                $s .= '</video>';

                return $s;
            }, $text);
        }

        /* The IMG tag created an HTML image tag. Size is optional, and if size is used, the height is optional. To define both, using an x between both sizes defines them.

        One size: size=500
        Both: size=500x400 */
        $text = preg_replace_callback('/\[img\ssrc=(.*?)(\sclass=([a-zA-Z0-9._-]+))?(\ssize=([0-9]+)(x[0-9]+)?)?\]/i', function ($matches) {
            if (isset($matches[6])) {
                $size2 = 'height="'.str_replace('x', '', $matches[6]).'"';
            }
            if (isset($matches[5])) {
                $size1 = 'width="'.$matches[5].'"';
            }
            $url = $matches[1];
            if (isset($matches[3]) && !empty($matches[3])) {
                $class = 'class="'.$matches[3].'"';
            }

            $image = '<img src="'.$url.'"';
            $image .= (isset($class)) ? ' '.$class : '';
            $image .= (isset($size1)) ? ' '.$size1 : '';
            $image .= (isset($size2)) ? ' '.$size2 : '';
            $image .= '>';

            return $image;
        }, $text);

        /* The URL tag is also a bit more complicating to parse. It supportes http, https, and mailto links.
         * It also supports opening links in a new tab using the newtab directive */
        $text = preg_replace_callback('/\[url=(http:\/\/|https:\/\/|mailto:)(.*?)(\snewtab)?\](.*?)\[\/url\]/i', function ($matches) {
            $target = $matches[3] ? ' target="_blank">' : '>';

            $hintURL = explode('/', $matches[2])[0];
            $hint = '<sup>['.$hintURL.']</sup>';

            $link = '<a href="'
                .$matches[1].$matches[2].'"'
                .$target
                .$matches[4]
                .'</a> '.$hint;

            return $link;
        }, $text);

        // The function that parses all the code. This is run before the [code][/code] and emoticons are parsed
        $text = preg_replace($pattern, $replace, $text);

        // Emoticons
        // Gotta be done at the end, but before [code]
        if (strstr($text, '[code') || strstr($text, '[terminal')) {
            if (preg_match('#\[code=([a-zA-Z0-9]+)](.+)\[/code]#sU', $text)
                ||
                preg_match('#\[terminal\suser=([a-zA-Z0-9._-]+)\shost=([a-zA-Z0-9._-]+)(\stheme=([a-zA-Z0-9]+))?\](.+)\[\/terminal\]#sU', $text)) {
                $text = self::parseEmoticons($text);
            }
        } else {
            $text = self::parseEmoticons($text);
        }

        $renderCode = $this->_renderCode;
        // This is the parsing for the code. Since it doesn't get parsed with the rest of the tags
        // and is parsed using CodeDocument, it's parsed separately from everything else.
        $text = preg_replace_callback('#\[code=([a-zA-Z0-9]+)](.+)\[/code]#sU', function ($matches) use ($renderCode) {
            if ($renderCode) {
                $geshi = CodeDocument::getInstance();
                $m = html_entity_decode($matches[2]);
                $geshi->loadDocument($m, $matches[1]);

                return $geshi->parse();
            } else {
                $m = html_entity_decode($matches[2]);

                return "<pre><code class=\"language-{$matches[1]}\">{$m}</code></pre>";
            }
        }, $text);

        // terminal. Is parsed away from emoticons
        $text = preg_replace_callback('#\[terminal\suser=([a-zA-Z0-9._-]+)\shost=([a-zA-Z0-9._-]+)(\stheme=([a-zA-Z0-9\-]+))?\](.+)\[\/terminal\]#sU', function ($m) {
            $terminal01 = '<link rel="stylesheet" type="text/css" href="https://cdn.kalebklein.com/kparser/term/terminal.css">';

            $style = (empty($m[3])) ? 'default' : $m[4];

            $terminal01 .= '<link rel="stylesheet" type="text/css" href="https://cdn.kalebklein.com/kparser/term/themes/'.$style.'.css"><div class="terminal"><div class="terminal-header"><div class="buttons"><div class="terminal-button quit"></div><div class="terminal-button maximize"></div><div class="terminal-button minimize"></div></div><div class="title">Terminal: '.$m[1].'@'.$m[2].' ~</div></div><div class="terminal-body"><div class="body-container">';

            // A given command
            $m[5] = preg_replace_callback('#\[command\](.+)\[\/command\]#sU', function ($mm) use ($m) {
                $terminal02 = '<div class="command-line"><div class="hostname">[<span class="user">'.$m[1].'</span><span class="at">@</span><span class="host">'.$m[2].'</span> <span class="where">~</span>]: #</div><div class="command">'.$mm[1].'</div></div>';

                return $terminal02;
            }, $m[5]);

            // If you wish to give a response to a command
            $m[5] = preg_replace_callback('#\[response\](.+)\[\/response\]#sU', function ($mmm) {
                $terminal02 = '<div class="command-line"><div class="hostname"></div><div class="command command-response">'.$mmm[1].'</div></div>';

                return $terminal02;
            }, $m[5]);

            $terminal03 = '</div></div></div>';

            $terminal = $terminal01.$m[5].$terminal03;

            return $terminal;
        }, $text);

        // If this is a comment, enable linebreaks
        // If not, the [nl] tag takes care of newlines
        if ($comment) {
            $text = nl2br($text);
        }

        if ($striptags) {
            return strip_tags($text);
        } else {
            return $text;
        }
    }

    /**
     * parseEmoticons - Parses certain characters for showing emoticons. This is only run when comment
     * is enabled in the parse() method.
     *
     * @param $text - The text to be parsed
     *
     * @return mixed - The image returned from the parsed text
     */
    private function parseEmoticons($text)
    {
        $emote = [
            'angry'     => 'angry',
            'arrow'     => 'arrow',
            'bigsmile'  => 'biggrin',
            'blink'     => 'blink',
            'cool'      => 'cool',
            'dunno'     => 'dry',
            '!'         => 'exclamation',
            'omg'       => 'huh',
            'laugh'     => 'laugh',
            'ohmy'      => 'ohmy',
            'ninja'     => 'ph34r',
            'puke'      => 'puke',
            '??'        => 'question',
            'we'        => 'rolleyes',
            'frown'     => 'sad',
            'smile'     => 'smile',
            'tongue'    => 'tongue',
            '123'       => 'unsure',
            'wink'      => 'wink',
        ];

        $swaparray = [
            '??',
            '!',
            'we',
            '123',
        ];

        foreach ($emote as $key => $value) {
            //echo ((in_array($key, $swaparray)) ? "echo value | {$value}" : "echo key | {$key}") . "<br>";
            $alt = (in_array($key, $swaparray)) ? $value : $key;
            $text = str_replace(
                ':'.$key.':',
                '<img src="https://cdn.kalebklein.com/kparser/img/'
                .$value
                .'.gif" alt="'
                .$alt
                .'">',
                $text
            );
        }

        return $text;
    }
}
