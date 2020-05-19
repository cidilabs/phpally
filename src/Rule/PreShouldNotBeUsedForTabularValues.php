<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  pre element should not be used to create tabular layout.
*  This error is generated for each pre element.
*/
class PreShouldNotBeUsedForTabularValues extends BaseRule
{
    public static $severity = self::SEVERITY_SUGGESTION;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('pre') as $pre) {
			$rows = preg_split('/[\n\r]+/', $pre->nodeValue);
			if (count($rows) > 1)
				$this->setIssue($pre);
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}