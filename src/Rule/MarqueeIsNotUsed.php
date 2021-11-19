<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Marquee element is not used.
*  This error is generated for all Marquee elements.
*/
class MarqueeIsNotUsed extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('marquee') as $m) {
			$this->setIssue($m);
            $this->totalTests++;

        }
        
        return count($this->issues);
    }

}