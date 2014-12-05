<?php namespace KalebKlein\KParser;

use GeSHi;

class Document
{
	private static $_instance;
	private $_code;
	private $_language;

	public function loadDocument($code, $lang)
	{
		$this->_language = $lang;
		$this->_code = new GeSHi($code, strtolower($lang));
		$this->_code->set_header_type(GESHI_HEADER_PRE);
		$this->_code->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
		$this->_code->enable_keyword_links(false);
		$this->_code->set_tab_width(4);
		$this->_code->set_overall_class('codeBlock');
	}

	public function parse()
	{
		$return = "";
		$return .= "<div class='codeBlock codeBlockHeader'>Code Language: " . $this->_language . "</div>";
		$return .= $this->_code->parse_code();
		return $return;
	}

	public static function getInstance()
	{
		self::$_instance = new Document();
		return self::$_instance;
	}
}
