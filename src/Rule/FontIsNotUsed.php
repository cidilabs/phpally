<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Decorative imgs should not have an alt attribute
*/
class FontIsNotUsed extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('font') as $b) {
			$this->setIssue($b);
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}