<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  All objects contain a text equivalent of the object.
*  object element must contain a text equivalent for the object in case the object can't be rendered.
*	@link http://quail-lib.org/test-info/objectMustContainText
*/
class ObjectMustContainText extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('object') as $object) {
			if (!$object->nodeValue || trim($object->nodeValue) == '')
				$this->setIssue($object);
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}