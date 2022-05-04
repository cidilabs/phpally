<?php

namespace CidiLabs\PhpAlly\Rule;

use CidiLabs\PhpAlly\PhpAllyIssue;
use CidiLabs\PhpAlly\PhpAllyRuleInterface;
use CidiLabs\PhpAlly\HtmlElements;
use DOMDocument;
use DOMElement;

class BaseRule implements PhpAllyRuleInterface {

    protected $dom;
    protected $previewElement = null;
    protected $css = '';
    protected $issues = [];
    protected $errors = [];
    protected $lang;
    protected $strings = array('en' => '');

    const ALT_TEXT_LENGTH_LIMIT = 125;
    const DOC_LENGTH = 1500;
    const MAX_WORD_COUNT = 3000;

    protected $altTextLengthLimit;
    protected $minDocLengthForHeaders;
    protected $maxWordCount;
    protected $totalTests = 0;

    public function __construct(DOMDocument $dom, $options = [])
    {
        $this->dom = $dom;
        $this->options = $options;
        $this->lang = isset($options['lang']) ? $options['lang'] : 'en';
        $this->css = isset($options['css']) ? $options['css'] : '';

        $this->altTextLengthLimit = isset($options['altTextLengthLimit']) 
            ? $options['alttextLengthLimit'] : self::ALT_TEXT_LENGTH_LIMIT;
        $this->minDocLengthForHeaders = isset($options['minDocLengthForHeaders']) 
            ? $options['minDocLengthForHeaders'] : self::DOC_LENGTH;
        $this->maxWordCount = isset($options['maxWordCount']) 
            ? $options['maxWordCount'] : self::MAX_WORD_COUNT;
    }

    public function id()
    {
        return self::class;
    }

    public function getCss()
    {
        return $this->css;
    }

    public function setCss($css)
    {
        $this->css = $css;
    }

    public function check()
    {
        return true;
    }

	public function getOptions()
	{
		return $this->options;
	}

    public function getPreviewElement(DOMElement $elem = null)
    {
        return null;
    }

	public function setPreviewElement(DOMElement $elem = null)
	{
		$this->previewElement = $elem;
	}

    public function getAllElements($tags = null, $options = false, $value = true) {
		if(!is_array($tags)) {
            $tags = array($tags);
        }

		if($options !== false) {
			$temp = new htmlElements();
			$tags = $temp->getElementsByOption($options, $value);
		}
		$result = array();

		if(!is_array($tags)) {
            return array();
        }

		foreach($tags as $tag) {
			$elements = $this->dom->getElementsByTagName($tag);
			if($elements) {
				foreach($elements as $element) {
					$result[] = $element;
				}
			}
        }
        
		if(count($result) == 0) {
            return array();
        }

		return $result;
	}

    /**
	*	Interface method for tests to call to lookup the style information for a given DOMNode
	*	@param object $element A DOMElement/DOMNode object
	*	@return array An array of style information (can be empty)
	*/
	public function getStyle($element) {
		//To prevent having to parse CSS unless the info is needed,
		//we check here if CSS has been set, and if not, run off the parsing
		//now.
		// if(!$this->css) {
		// 	$this->loadCSS();
		// 	$this->setStyles();
		// }
		if(!is_a($element, 'DOMElement')) {
			return array();
		}
		$style = $this->getNodeStyle($element);
		if(isset($style['background-color']) || isset($style['color'])){
			$style = $this->walkUpTreeForInheritance($element, $style);
		}

		if($element->hasAttribute('style')) {
			$inline_styles = explode(';', $element->getAttribute('style'));
			foreach($inline_styles as $inline_style) {
				$s = explode(':', $inline_style);

				if(isset($s[1])){	// Edit:  Make sure the style attribute doesn't have a trailing ;
					$style[trim($s[0])] = trim(strtolower($s[1]));
				}
			}
		}
		if($element->tagName === "strong"){
			$style['font-weight'] = "bold";
		}
		if($element->tagName === "em"){
			$style['font-style'] = "italic";
		}
		if(!is_array($style)) {
			return array();
		}
		return $style;
	}

    /**
	*	Returns the style from the CSS index for a given element by first
	*	looking into its tag bucket then iterating over every item for an
	*	element that matches
	*	@param object The DOMNode/DOMElement object in queryion
	*	@retun array An array of all the style elements that _directly_ apply
	*	 			 to that element (ignoring inheritance)
	*
	*/
	public function getNodeStyle($element) {
		$style = array();

		if($element->hasAttribute('quail_style_index')) {
			$style = $this->style_index[$element->getAttribute('quail_style_index')];
		}
		// To support the deprecated 'bgcolor' attribute
		if($element->hasAttribute('bgcolor') &&  in_array($element->tagName, $this->deprecated_style_elements)) {
			$style['background-color'] = $element->getAttribute('bgcolor');
		}
		if($element->hasAttribute('style')) {
			$inline_styles = explode(';', $element->getAttribute('style'));
			foreach($inline_styles as $inline_style) {
				$s = explode(':', $inline_style);

				if(isset($s[1])){	// Edit:  Make sure the style attribute doesn't have a trailing ;
					$style[trim($s[0])] = trim(strtolower($s[1]));
				}
			}
		}

		return $style;
	}

    /**
	*	A helper function to walk up the DOM tree to the end to build an array
	*	of styles.
	*	@param object $element The DOMNode object to walk up from
	*	@param array $style The current style built for the node
	*	@return array The array of the DOM element, altered if it was overruled through css inheritance
	*/
	private function walkUpTreeForInheritance($element, $style) {
		while(property_exists($element->parentNode, 'tagName')) {
			$parent_style = $this->getNodeStyle($element->parentNode);
			if(is_array($parent_style)) {
				foreach($parent_style as $k => $v) {
					if(!isset($style[$k]) /*|| in_array($style[$k]['value'], $this->inheritance_strings)*/) {
						$style[$k] = $v;
					}

					if((!isset($style['background-color'])) || strtolower($style['background-color']) == strtolower("#FFFFFF")){
						if($k == 'background-color'){
							$style['background-color'] = $v;
						}
					}

					if((!isset($style['color'])) || strtolower($style['color']) == strtolower("#000000")){
						if($k == 'color'){
							$style['color'] = $v;
						}
					}
				}
			}
			$element = $element->parentNode;
		}
		return $style;
	}

	// Helper function to check if text node children of an element have a color
	public function childrenHaveTextColor($element)
	{
		$children = $element->childNodes;
		foreach ($children as $child) {
			// Check if its a DOM element
			if ($child->nodeType !== 1 ) { //Element nodes are of nodeType 1. Text 3. Comments 8. etc rtm
				continue;
			}

			$child_style = $this->getNodeStyle($child);

			if(is_array($child_style)) {
				if (isset($child_style['color'])){
					return true;
				}
			}
		}

		return false;
	}


    public function elementContainsReadableText($element)
    {
        if (is_a($element, 'DOMText')) {
            if (trim($element->wholeText) != '') {
                return true;
            }
        } else {
            if (trim($element->nodeValue) != '' ||
                ($element->hasAttribute('alt') && trim($element->getAttribute('alt')) != '')
            ) {
                return true;
            }
            if (method_exists($element, 'hasChildNodes') && $element->hasChildNodes()) {
                foreach ($element->childNodes as $child) {
                    if ($this->elementContainsReadableText($child)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function setIssue($element, $ruleId = null, $metadata = null)
    {
		if (!isset($ruleId)) {
			$ruleId = $this->id();
		}

		$ruleId = str_replace(['CidiLabs\\PhpAlly\\Rule\\','App\\Rule\\'], '', $ruleId);
		$previewElement = $this->previewElement;
		$isDocumentElement = false;
		
        if ($element) {
            $elementClasses = $element->getAttribute('class');
            if ($elementClasses && (strpos($elementClasses, 'phpally-ignore') !== false)) {
                return;
            }
        }

        $this->issues[] = new PhpAllyIssue($ruleId, $element, $previewElement, $metadata);
    }

    public function getIssues()
    {
        return $this->issues;
    }

    public function getTotalTests()
    {
        return $this->totalTests;
    }
    public function IncrementTotalTests()
    {
        return $this->totalTests++;
    }

    public function setError($errorMsg) 
    {
        $this->errors[] = $errorMsg;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
	*	Returns a translated variable. If the translation is unavailable, English is returned
	*	Because tests only really have one string array, we can get all of this info locally
	*	@return mixed The translation for the object
	*/
    public function translation() {
        if(isset($this->strings[$this->lang])) {
			return $this->strings[$this->lang];
		}
		if(isset($this->strings['en'])) {
			return $this->strings['en'];
		}
		return false;
    }

    public function setLanguage($language) {
        $this->lang = $language;
    }

    /**
	*	To minimize notices, this compares an object's property to the value
	*	and returns true or false. False will also be returned if the object is
	*	not really an object, or if the property doesn't exist at all
	*	@param object $object The object too look at
	*	@param string $property The name of the property
	*	@param mixed $value The value to check against
	*	@param bool $trim Whether the property value should be trimmed
	*	@param bool $lower Whether the property value should be compared on lower case
	**/
	function propertyIsEqual($object, $property, $value, $trim = false, $lower = false) {
		if(!is_object($object)) {
			return false;
		}
		if(!property_exists($object, $property)) {
			return false;
		}
		$property_value = $object->$property;
		if($trim) {
			$property_value = trim($property_value);
			$value = trim($value);
		}
		if($lower) {
			$property_value = strtolower($property_value);
			$value = strtolower($value);
		}
		return ($property_value == $value);
	}


}