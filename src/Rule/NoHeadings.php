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
        // Ignore html with script tags
        if (count($this->getAllElements('script')) === 0) {
            $document_string = $this->dom->textContent;
            
            if (strlen($document_string) > $this->minDocLengthForHeaders){
                if (!$this->getAllElements('h1')
                    && !$this->getAllElements('h2')
                    && !$this->getAllElements('h3')
                    && !$this->getAllElements('h4')
                    && !$this->getAllElements('h5')
                    && !$this->getAllElements('h6')) {
                    /* 
                    Since this rule sets the document element as the issue
                    we set this flag here so we can process it accordingly in UDOIT. 
                    */
                    $metadata = array('isDocumentElement' => true);
                    $this->setIssue($this->dom->documentElement, null, json_encode($metadata));
                }
            }
            $this->totalTests++;


            return count($this->issues);
        }
    }

}