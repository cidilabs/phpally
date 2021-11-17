<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Decorative imgs should not have an alt attribute
*/
class BaseFontIsNotUsed extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('basefont') as $b) {
			$this->setIssue($b);
            $this->totalTests++;
		}
        
        return count($this->issues);
    }

}