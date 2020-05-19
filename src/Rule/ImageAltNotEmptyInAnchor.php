<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Alt text for all img elements used as source anchors is not empty when there is no other text in the anchor.
*  img element cannot have alt attribute value of null or whitespace if the img element is contained by an A element and there is no other link text.
*	@link http://quail-lib.org/test-info/imgAltNotEmptyInAnchor
*/
class ImageAltNotEmptyInAnchor extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('a') as $a) {
			if (!$a->nodeValue && $a->childNodes) {
				foreach ($a->childNodes as $child) {
					if ($this->propertyIsEqual($child, 'tagName', 'img')
						&& trim($child->getAttribute('alt')) == '')
							$this->setIssue($child);
				}
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}