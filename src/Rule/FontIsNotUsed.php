<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Decorative imgs should not have an alt attribute
*/
class FontIsNotUsed extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('font') as $b) {
			$this->setIssue($b);
            $this->totalTests++;
		}
        
        return count($this->issues);
    }

}