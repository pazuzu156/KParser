<?php namespace Pazuzu156\KParser;

/**
 * Class KParser
 *
 * Parsing class for parsing supported tags into HTML. For use in blogs and such. Or whatever you want it
 * to be used for. :)
 *
 * @package KalebKlein\KParser
 * @copyright 2014 Kaleb Klein
 * @author Kaleb Klein <klein.jae@gmail.com>
 * @version 1.0.4
 */
class KParser
{
	/**
	 * parse - Parses all the different tags used in the page content
	 *
	 * @param $text - The content to be parsed
	 * @param bool $comment - Comment check. Certain tags are not parsed if set to true
	 * @param bool $striptags - Strips parsable tags from text. If you don't want anything parsed
	 * @return mixed - The parsed content returned
	 */
	public function parse($text, $comment = false, $striptags = false)
	{
		/* Global patterns for code. Ones to always be parsed. Also the simplest patterns */
		$pattern[] = '/\[p\](.*?)\[\/p\]/i';
		$replace[] = '<p>$1</p>';
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
		$pattern[] = '/\[size=([0-9]+)(?:px|pt)?\](.*?)\[\/size\]/i';
		$replace[] = '<span style="font-size: $1;">$2</span>';
		$pattern[] = '/\[color=(\#[a-fA-F0-9]+)\](.*?)\[\/color\]/i';
		$replace[] = '<span style="color: $1">$2</span>';
		$pattern[] = '/\[color=([a-zA-Z]+)\](.*?)\[\/color\]/i';
		$replace[] = '<span style="color: $1">$2</span>';
		$pattern[] = '/\[center\](.*?)\[\/center\]/i';
		$replace[] = '<div style="text-align: center;">$1</div>';
		$pattern[] = '/\[quote\](.*?)\[\/quote\]/i';
		$replace[] = '<blockquote>$1</blockquote>';
		$pattern[] = '/\[quote\=([a-zA-Z0-9\.\_\-\s]+)\](.*?)\[\/quote\]/i';
		$replace[] = '<blockquote cite="$1">$2</blockquote>';
		$pattern[] = '/\[url\](.*?)\[\/url\]/i';
		$replace[] = '<a href="$1">$1</a>';
		
		/* If it's a comment, then certain tags must not be rendered. Namely ones that edit the style of the page */
		if(!$comment)
		{
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
			$text = preg_replace_callback('#\[youtube\surl=(.*)\]#sU', function($matches) {
				$url = $matches[1];
				$e = explode("u.", $url);
				if(count($e) == 2)
				{
					$exp = explode("/", $e[1]);
					$videoID = $exp[1];
				}
				else
				{
					$exp = explode("?v=", $url);
					$videoID = $exp[1];
				}

				$s = '<iframe id="ytvid" class="ytvid" width="640" height="390" frameborder="0" '
					. 'src="http://cdn.kalebklein.com/kparser/loadytvid.php?videoID='
					. $videoID . '"'
					. ' style="display: block; overflow: hidden; padding: 0;"'
					. ' scrolling="no">'
					. '<p>Sorry, your browser doesn\'t support the iFrame element!</p></iframe>';
				return $s;
			}, $text);
		}
		
		/* The IMG tag created an HTML image tag. Size is optional, and if size is used, the height is optional. To define both, using an x between both sizes defines them.

		One size: size=500
		Both: size=500x400 */
		$text = preg_replace_callback('/\[img\ssrc=(.*?)(\ssize=([0-9]+)(x[0-9]+)?)?\]/i', function($matches)
		{
			if(isset($matches[4]))
				$size2 = 'height="' . str_replace('x', '', $matches[4]) . '"';
			if(isset($matches[3]))
				$size1 = 'width="' . $matches[3] . '"';
			$url = $matches[1];
			
			$image = '<img src="' . $url . '"';
			$image .= (isset($size1)) ? " " . $size1 : "";
			$image .= (isset($size2)) ? " " . $size2 : "";
			$image .= ">";
			
			return $image;
		}, $text);

		/* The URL tag is also a bit more complicating to parse. It supportes http, https, and mailto links.
		 * It also supports opening links in a new tab using the newtab directive */
		$text = preg_replace_callback('/\[url=(http:\/\/|https:\/\/|mailto:)(.*?)(\snewtab)?\](.*?)\[\/url\]/i', function($matches) {
			$target = $matches[3] ? " target=\"_blank\">" : ">";

			$link = "<a href=\""
				. $matches[1] . $matches[2] . "\""
				. $target
				. $matches[4]
				. "</a>";

			return $link;
		}, $text);

		// The function that parses all the code. This is run before the [code][/code] and emoticons are parsed
		$text = preg_replace($pattern, $replace, $text);

		// Emoticons
		// Gotta be done at the end, but before [code]
		if(strstr($text, "[code"))
		{
			if(preg_match('#\[code=([a-zA-Z0-9]+)](.+)\[/code]#sU', $text))
			{
				$text = self::parseEmoticons($text);
			}
		}
		else
		{
			$text = self::parseEmoticons($text);
		}

		// This is the parsing for the code. Since it doesn't get parsed with the rest of the tags
		// and is parsed using CodeDocument, it's parsed separately from everything else.
		$text = preg_replace_callback('#\[code=([a-zA-Z0-9]+)](.+)\[/code]#sU',function($matches){
			$geshi = CodeDocument::getInstance();
			$m = html_entity_decode($matches[2]);
			$geshi->loadDocument($m, $matches[1]);
			return $geshi->parse();
		}, $text);

		// If this is a comment, enable linebreaks
		// If not, the [nl] tag takes care of newlines
		if($comment)
			$text = nl2br($text);

		if($striptags)
			return strip_tags($text);
		else
			return $text;
	}

	/**
	 * parseEmoticons - Parses certain characters for showing emoticons. This is only run when comment
	 * is enabled in the parse() method
	 *
	 * @param $text - The text to be parsed
	 * @return mixed - The image returned from the parsed text
	 */
	private function parseEmoticons($text)
	{
		$emote = array(
			"angry" 	=> "angry",
			"arrow" 	=> "arrow",
			"bigsmile" 	=> "biggrin",
			"blink" 	=> "blink",
			"cool" 		=> "cool",
			"dunno" 	=> "dry",
			"!" 		=> "exclamation",
			"omg" 		=> "huh",
			"laugh" 	=> "laugh",
			"ohmy" 		=> "ohmy",
			"ninja" 	=> "ph34r",
			"puke" 		=> "puke",
			"??" 		=> "question",
			"we" 		=> "rolleyes",
			"frown" 	=> "sad",
			"smile" 	=> "smile",
			"tongue" 	=> "tongue",
			"123" 		=> "unsure",
			"wink" 		=> "wink"
		);

		$swaparray = array(
			'??',
			'!',
			'we',
			'123'
		);

		foreach($emote as $key => $value)
		{
			//echo ((in_array($key, $swaparray)) ? "echo value | {$value}" : "echo key | {$key}") . "<br>";
			$alt = (in_array($key, $swaparray)) ? $value : $key;
			$text = str_replace(
				':'. $key . ':',
				'<img src="http://cdn.kalebklein.com/kparser/img/'
				. $value
				. '.gif" alt="'
				. $alt
				. '">',
				$text
			);
		}

		return $text;
	}
}
