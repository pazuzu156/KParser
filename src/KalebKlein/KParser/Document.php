<?php namespace KalebKlein\KParser;

use GeSHi; // GeSHi is required for this package

class Document
{
	/**
	 * @var $_instance - The instance of Document
	 */
	private static $_instance;

	/**
	 * @var $_geshi - Holds the GeSHi instance that is used in parse()
	 */
	private $_geshi;

	/**
	 * @var $_language - The language if the code (For highlighting correct lang)
	 */
	private $_language;

	/**
	 * loadDocument - Loads the current document into a new GeSHi instance
	 * used for syntax highlighting using the [code][/code] block
	 *
	 * @param $code - The code to be parsed through GeSHi
	 * @param $lang - The language the code falls under
	 */
	public function loadDocument($code, $lang)
	{
		$this->_language = $lang;
		$this->_geshi = new GeSHi($code, strtolower($lang));
		$this->_geshi->set_header_type(GESHI_HEADER_PRE);
		$this->_geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
		$this->_geshi->enable_keyword_links(false);
		$this->_geshi->set_tab_width(4);
		$this->_geshi->set_overall_class('codeBlock');
	}

	/**
	 * parse - Parses the code that has been loaded into the GeSHi instance
	 * through loadDocument()
	 *
	 * @return string - The parsed code in HTML
	 */
	public function parse()
	{
		$return = "";
		$return .= "<div class='codeBlock codeBlockHeader'>Code Language: " . $this->_language . "</div>";
		$return .= $this->_geshi->parse_code();
		return $return;
	}

	/**
	 * getInstance - Gets the instnace of Document
	 *
	 * @return Document - the new Document instance
	 */
	public static function getInstance()
	{
		self::$_instance = new Document();
		return self::$_instance;
	}
}
