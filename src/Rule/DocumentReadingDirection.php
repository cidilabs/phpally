<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use DOMXPath;

/**
*  All changes in text direction are marked using the dir attribute.
*  Identify changes in the text direction of text that includes nested directional runs 
*  by providing the dir attribute on inline elements. A nested directional run is a run of text 
*  that includes mixed directional text, for example, a paragraph in English containing a quoted 
*  Hebrew sentence which in turn includes a quotation in French.
*/
class DocumentReadingDirection extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $right_to_left = array('he', 'ar');
        $xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach ($entries as $element) {
			if (in_array($element->getAttribute('lang'), $right_to_left)) {
				if ($element->getAttribute('dir') != 'rtl')
				 	$this->setIssue($element);
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}