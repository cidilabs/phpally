<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Objects may not be properly viewable on mobile devices.
*  This test adds a suggestion to consider mobile users when relying on objects for multimedia content.
*/
class ObjectTagDetected extends BaseRule
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

    public function getPreviewElement(DOMElement $a = null)
    {
        return $a->parentNode;
    }
}