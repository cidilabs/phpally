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
    public static $severity = self::SEVERITY_SUGGESTION;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $doc_length = self::DOC_LENGTH;
		$document_string = $this->dom->textContent;
		
		if (strlen($document_string) > $doc_length){
			if (!$this->getAllElements('h1')
				&& !$this->getAllElements('h2')
				&& !$this->getAllElements('h3')
				&& !$this->getAllElements('h4')
				&& !$this->getAllElements('h5')
				&& !$this->getAllElements('h6')) {
				$this->setIssue(null);
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}