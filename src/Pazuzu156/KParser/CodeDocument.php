<?php namespace Pazuzu156\KParser;

use GeSHi; // GeSHi is required for this package

/**
 * Class CodeDocument
 *
 * CodeDocument takes code from the [code][/code] block and parses it into HTML
 * using GeSHi
 *
 * @package KalebKlein\KParser
 */
class CodeDocument
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
		$this->_language = $lang; // Set language of CodeDocument
		$this->_geshi = new GeSHi($code, strtolower($lang)); // Create new GeSHi instance using code and lang provided
		$this->_geshi->set_header_type(GESHI_HEADER_PRE); // Set header type | For display type
		$this->_geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS); // Enable line numbers
		$this->_geshi->enable_keyword_links(false); // Disable keyword links in code
		$this->_geshi->set_tab_width(4); // Set the tab width of code
		$this->_geshi->set_overall_class('codeBlock'); // Class for custom styling
	}

	/**
	 * parse - Parses the code that has been loaded into the GeSHi instance
	 * through loadDocument()
	 *
	 * @return string - The parsed code in HTML
	 */
	public function parse()
	{
		// Codeblock header | Shows the language being used
		$return = "<div class='codeBlock codeBlockHeader'>Code Language: " . $this->_geshi->get_language_name() . "</div>";
		$return .= $this->_geshi->parse_code(); // Parses code using the GeSHi instance
		return $return;
	}

	/**
	 * getInstance - Gets the instnace of CodeDocument
	 *
	 * @return CodeDocument - the new Document instance
	 */
	public static function getInstance()
	{
		if(self::$_instance == NULL)
			self::$_instance = new CodeDocument;

		return self::$_instance;
	}
}
