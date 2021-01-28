<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  object may require a long description.
*  This error is generated for every object element.
*/
class ObjectShouldHaveLongDescription extends BaseRule
{
    
    
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