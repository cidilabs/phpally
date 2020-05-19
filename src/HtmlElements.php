<?php

namespace CidiLabs\PhpAlly;

/**
*	This is a helper class which organizes all the HTML
*	tags into groups for finding, for example, all elements
*	which can possibly hold text that will be rendered on screen.
*
*/
class HtmlElements {
	/**
	*	@var array An array of HTML tag names and their attributes
	*	@todo add HTML5 elements here
	*/
	static $html_elements = array(
		'img'        => array('text' => false),
		'p'          => array('text' => true),
		'pre'        => array('text' => true),
		'span'       => array('text' => true),
		'div'        => array('text' => true),
		'applet'     => array('text' => false),
		'embed'      => array('text' => false, 'media' => true),
		'object'     => array('text' => false, 'media' => true),
		'area'       => array('imagemap' => true),
		'b'          => array('text' => true, 'non-emphasis' => true),
		'i'          => array('text' => true, 'non-emphasis' => true),
		'font'       => array('text' => true, 'font' => true),
		'h1'         => array('text' => true, 'header' => true),
		'h2'         => array('text' => true, 'header' => true),
		'h3'         => array('text' => true, 'header' => true),
		'h4'         => array('text' => true, 'header' => true),
		'h5'         => array('text' => true, 'header' => true),
		'h6'         => array('text' => true, 'header' => true),
		'ul'         => array('text' => true, 'list' => true),
		'dl'         => array('text' => true, 'list' => true),
		'ol'         => array('text' => true, 'list' => true),
		'blockquote' => array('text' => true, 'quote' => true),
		'q'          => array('text' => true, 'quote' => true),
		'acronym'    => array('acronym' => true, 'text' => true),
		'abbr'       => array('acronym' => true, 'text' => true),
		'input'      => array('form' => true),
		'select'     => array('form' => true),
		'textarea'   => array('form' => true),
    );
    
    public function id()
    {
        return self::class;
    }

	/**
	*	Retrieves elements by an option.
	*	@param string $option The option to search fore
	*	@param bool $value Whether the option should be true or false
	*	@return array An array of HTML tag names
	*	@todo this should cache results in a static variable, as many of these can be iterated over again
	*/
	public static function getElementsByOption($option, $value = true)
	{
		foreach(self::$html_elements as $k => $element)
		{
			if(isset($element[$option]) && $element[$option] == $value)
			{
				$results[] = $k;
			}
		}
		return $results;
	}
}