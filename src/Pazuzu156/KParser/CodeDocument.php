<?php

namespace Pazuzu156\KParser;

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
     * CodeDocument instance
     *
     * @var \Pazuzu156\KParser\CodeDocument
     */
    private static $_instance;

    /**
     * GeSHI Instance
     *
     * @var \GeSHI
     */
    private $_geshi;

    /**
     * CodeDocument language to render in
     *
     * @var string
     */
    private $_language;

    /**
     * loadDocument - Loads the current document into a new GeSHi instance
     * used for syntax highlighting using the [code][/code] block
     *
     * @param $code - The code to be parsed through GeSHi
     * @param $lang - The language the code falls under
     *
     * @return void
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
        $this->_geshi->set_code_style('font-family: dejavu, monospace; font-size: 11px;', true);
    }

    /**
     * parse - Parses the code that has been loaded into the GeSHi instance
     * through loadDocument()
     *
     * @return string
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
     * @return \Pazuzu156\KParser\CodeDocument
     */
    public static function getInstance()
    {
        if(self::$_instance == NULL)
            self::$_instance = new CodeDocument;

        return self::$_instance;
    }
}
