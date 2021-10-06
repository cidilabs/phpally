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
    
    
    public function id()
    {
        return self::class;
    }

    /**
    *  All objects contain a text equivalent of the object.
    *  object element must contain a text equivalent for the object in case the object can't be rendered.
    *	@link http://quail-lib.org/test-info/objectMustContainText
    */
	function check()
	{
		foreach ($this->getAllElements('object') as $object) {
			if ((!$object->nodeValue || trim($object->nodeValue) == '')
				&& !($object->hasAttribute('aria-label') && strlen($object->getAttribute('aria-label')) > 0)
				&& !($object->hasAttribute('aria-labelledby') && strlen($object->getAttribute('aria-labelledby')) > 0)
                && (!$object->hasAttribute('alt') || trim($object->getAttribute('alt')) == '')){
					$this->setIssue($object);
			}

            return count($this->issues);
		}   
	}

}