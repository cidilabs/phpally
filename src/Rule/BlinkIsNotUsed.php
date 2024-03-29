<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  blink element is not used.
*  This error is generated for all blink elements.
*/
class BlinkIsNotUsed extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('blink') as $b) {
			$this->setIssue($b);
            $this->totalTests++;
		}
        
        return count($this->issues);
    }

}