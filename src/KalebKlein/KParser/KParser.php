<?php namespace KalebKlein\KParser;

class KParser
{
	public function parse($text, $comment = false)
	{
		$pattern[] = '/\[p\](.*?)\[\/p\]/i';
		$replace[] = '<p>$1</p>';
		$pattern[] = '/\[b\](.*?)\[\/b\]/i';
		$replace[] = '<strong>$1</strong>';
		$pattern[] = '/\[i\](.*?)\[\/i\]/i';
		$replace[] = '<em>$1</em>';
		$pattern[] = '/\[img\ssrc=(.*?)\]/i';
		$replace[] = '<img src="$1">';
		$pattern[] = '/\[u\](.*?)\[\/u\]/i';
		$replace[] = '<span style="text-decoration: underline;">$1</span>';
		$pattern[] = '/\[strike\](.*?)\[\/strike\]/i';
		$replace[] = '<span style="text-decoration: line-through;">$1</span>';
		$pattern[] = '/\[over\](.*?)\[\/over\]/i';
		$replace[] = '<span style="text-decoration: overline;">$1</span>';

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

			$text = preg_replace_callback('#\[ytvid\surl=(.*)\]#sU', function($matches) {
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
				$s = "<iframe width='660' height='400' frameborder='0' src='http://cdn.kalebklein.com/kparser/loadytvid.php?videoID=" . $videoID . "' style='display: block; overflow: hidden; padding: 0;'><p>Sorry, you're browser doesn't support the iFrame element!</p></iframe>";
				return $s;
			}, $text);
		}

		$text = preg_replace_callback('#\[a\shref=(.*)\](.*)\[\/a\]#sU', function($matches) {
			return Views::linkTo($matches[1], $matches[2], true);
		}, $text);

		$text = preg_replace($pattern, $replace, $text);

		// Emoticons for comments
		// Gotta be done at the end, but before [code]
		if($comment)
		{
			if(strstr($text, "[code"))
			{
				if(preg_match('#\[code=([a-zA-Z0-9]+)](.+)\[/code]#sU', $text))
				{
					$text = KParser::parseEmoticons($text);
				}
			}
			else
			{
				$text = KParser::parseEmoticons($text);
			}
		}

		$text = preg_replace_callback('#\[code=([a-zA-Z0-9]+)](.+)\[/code]#sU',function($matches){
		$geshi = Document::getInstance();
		$m = html_entity_decode($matches[2]);
		$geshi->loadDocument($m, $matches[1]);
			return $geshi->parse();
		}, $text);


		if($comment)
			$text = nl2br($text);

		return $text;
	}

	private static function parseEmoticons($text)
	{
		$text = str_replace(":angry:", "<img src='http://cdn.kalebklein.com/kparser/img/angry.gif' alt='angry' />", $text);
		$text = str_replace(":arrow:", "<img src='http://cdn.kalebklein.com/kparser/img/arrow.gif' alt='arrow' />", $text);
		$text = str_replace(":bigsmile:", "<img src='http://cdn.kalebklein.com/kparser/img/biggrin.gif' alt='biggrin' />", $text);
		$text = str_replace(":blink:", "<img src='http://cdn.kalebklein.com/kparser/img/blink.gif' alt='blink' />", $text);
		$text = str_replace(":cool:", "<img src='http://cdn.kalebklein.com/kparser/img/cool.gif' alt='cool' />", $text);
		$text = str_replace(":dunno:", "<img src='http://cdn.kalebklein.com/kparser/img/dry.gif' alt='dry' />", $text);
		$text = str_replace(":!:", "<img src='http://cdn.kalebklein.com/kparser/img/exclamation.gif' alt='exclamation' />", $text);
		$text = str_replace(":omg:", "<img src='http://cdn.kalebklein.com/kparser/img/huh.gif' alt='huh' />", $text);
		$text = str_replace(":laugh:", "<img src='http://cdn.kalebklein.com/kparser/img/laugh.gif' alt='laugh' />", $text);
		$text = str_replace(":ohmy:", "<img src='http://cdn.kalebklein.com/kparser/img/ohmy.gif' alt='oh my' />", $text);
		$text = str_replace(":ninja:", "<img src='http://cdn.kalebklein.com/kparser/img/ph34r.gif' alt='ninja' />", $text);
		$text = str_replace(":puke:", "<img src='http://cdn.kalebklein.com/kparser/img/puke.gif' alt='puke' />", $text);
		$text = str_replace(":??:", "<img src='http://cdn.kalebklein.com/kparser/img/question.gif' alt='question' />", $text);
		$text = str_replace(":we:", "<img src='http://cdn.kalebklein.com/kparser/img/rolleyes.gif' alt='rolleyes' />", $text);
		$text = str_replace(":frown:", "<img src='http://cdn.kalebklein.com/kparser/img/sad.gif' alt='sad' />", $text);
		$text = str_replace(":smile:", "<img src='http://cdn.kalebklein.com/kparser/img/smile.gif' alt='smile' />", $text);
		$text = str_replace(":tongue:", "<img src='http://cdn.kalebklein.com/kparser/img/tongue.gif' alt='tongue' />", $text);
		$text = str_replace(":123:", "<img src='http://cdn.kalebklein.com/kparser/img/unsure.gif' alt='unsure' />", $text);
		$text = str_replace(":wink:", "<img src='http://cdn.kalebklein.com/kparser/img/wink.gif' alt='wink' />", $text);

		return $text;
	}
}
