<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  object user interface must be accessible.
*  If an object element contains a codebase attribute then the codebase attribute value must be null or whitespace.
*/
class ObjectInterfaceIsAccessible extends BaseRule
{
    public static $severity = self::SEVERITY_SUGGESTION;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('object') as $object) {
			$this->setIssue($object);
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}