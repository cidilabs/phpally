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

		$elements = $this->getAllElements('p');

		$document_string = "";

		foreach ($elements as $element) {
			$document_string .= $element->textContent;
		}

		if (strlen($document_string) > $doc_length){

			$no_headings = 0;

			if (!$this->getAllElements('h1')
				&& !$this->getAllElements('h2')
				&& !$this->getAllElements('h3')
				&& !$this->getAllElements('h4')
				&& !$this->getAllElements('h5')
				&& !$this->getAllElements('h6')) {
				$no_headings = true;
			} else {
				$no_headings = false;
			}

            // TODO: Figure out a better way to do this
			if ($no_headings) {
				$body = $this->getAllElements('body');

		        $this->setIssue($body[0]);
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}