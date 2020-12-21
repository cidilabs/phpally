<?php

namespace CidiLabs\PhpAlly\Rule;

use CidiLabs\PhpAlly\Rule\HtmlElement;

use DOMElement;

/**
* Test counts words for all text elements on page and suggests content chunking for pages longer than 3000 words.
*/
class ContentTooLong extends BaseRule
{
    public static $severity = self::SEVERITY_SUGGESTION;
    
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
		}
        $wordCount = str_word_count($pageText);

		if($wordCount > SELF::MAX_WORD_COUNT) {
			$this->setIssue(null);
		}

        return count($this->issues);
    }

    public function getPreviewElement(DOMElement $a = null)
    {
        return $a->parentNode;
    }
}