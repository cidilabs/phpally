<?php

namespace CidiLabs\PhpAlly\Rule;

use CidiLabs\PhpAlly\PhpAllyIssue;
use CidiLabs\PhpAlly\PhpAllyRuleInterface;
use CidiLabs\PhpAlly\HtmlElements;
use DOMDocument;
use DOMElement;

class BaseRule implements PhpAllyRuleInterface {

    protected $dom;
    protected $previewHtml = '';
    protected $css = '';
    protected $issues = [];
    protected $errors = [];
    protected $lang = 'en';
    protected $strings = array('en' => '');

    const SEVERITY_ERROR = 'error';
    const SEVERITY_SUGGESTION = 'suggestion';
    const ALT_TEXT_LENGTH_LIMIT = 125;
    const DOC_LENGTH = 1500;

    public function __construct(DOMDocument $dom, $css = '', $language_domain = 'en')
    {
        $this->dom = $dom;
        $this->css = $css;
        $this->lang = $language_domain;
    }

    public function id()
    {
        return self::class;
    }

    public function getCss()
    {

    }

    public function setCss($css)
    {

    }

    public function check()
    {
        return true;
    }

    public function getPreviewElement(DOMElement $elem = null)
    {
        return null;
    }

    public function getAllElements($tags = null, $options = false, $value = true) {
		if(!is_array($tags))
			$tags = array($tags);
		if($options !== false) {
			$temp = new htmlElements();
			$tags = $temp->getElementsByOption($options, $value);
		}
		$result = array();

		if(!is_array($tags))
			return array();
		foreach($tags as $tag) {
			$elements = $this->dom->getElementsByTagName($tag);
			if($elements) {
				foreach($elements as $element) {
					$result[] = $element;
				}
			}
		}
		if(count($result) == 0)
			return array();
		return $result;
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

    public function setIssue($element)
    {
        $this->issues[] = new PhpAllyIssue($this->id(), $element, $this->getPreviewElement($element));
    }

    public function getIssues()
    {
        return $this->issues;
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