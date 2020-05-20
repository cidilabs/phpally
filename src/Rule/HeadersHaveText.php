<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*	Headers should have text content so as not to confuse screen-reader users
*/
class HeadersHaveText extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements(null, 'header', true) as $header) {
			if (!$this->elementContainsReadableText($header)) {
				$this->setIssue($header);
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}