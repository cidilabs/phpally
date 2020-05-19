<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  blink element is not used.
*  This error is generated for all blink elements.
*/
class BlinkIsNotUsed extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('blink') as $b) {
			$this->setIssue($b);
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}