<?php

namespace CidiLabs\PhpAlly\Rule;

use CidiLabs\PhpAlly\Rule\HtmlElement;

use DOMElement;

/**
* Test counts words for all text elements on page and suggests content chunking for pages longer than 3000 words.
*/
class ContentTooLong extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $pageText = '';
		$wordCount = 0;
		foreach ($this->getAllElements(null, 'text') as $element) {
            $text = $element->nodeValue;

			if($text != null){
				$pageText = $pageText . $text;
			}
            $this->totalTests++;
		}
        $wordCount = str_word_count($pageText);

		if($wordCount > $this->maxWordCount) {
            /* 
            Since this rule sets the document element as the issue
            we set this flag here so we can process it accordingly in UDOIT. 
            */
            $metadata = array('isDocumentElement' => true);
			$this->setIssue($this->dom->documentElement->parentNode, null, json_encode($metadata));
		}

        return count($this->issues);
    }

    public function getPreviewElement(DOMElement $a = null)
    {
        return $a;
    }
}