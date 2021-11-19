<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  TODO, come back to this
*  CUSTOM TEST FOR UDOIT
*  Checks if content uses heading elements (h1 - h6) at all
*/
class NoHeadings extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $document_string = $this->dom->textContent;
		
		if (strlen($document_string) > $this->minDocLengthForHeaders){
			if (!$this->getAllElements('h1')
				&& !$this->getAllElements('h2')
				&& !$this->getAllElements('h3')
				&& !$this->getAllElements('h4')
				&& !$this->getAllElements('h5')
				&& !$this->getAllElements('h6')) {
				$this->setIssue($this->dom->documentElement);
			}
		}
        $this->totalTests++;


        return count($this->issues);
    }

}