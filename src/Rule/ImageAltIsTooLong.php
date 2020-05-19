<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Alt text is not the same as the filename unless author has confirmed it is correct.
*  img element cannot have alt attribute value that is the same as its src attribute.
*	@link http://quail-lib.org/test-info/imgAltIsDifferent
*/
class ImageAltIsTooLong extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $limit = self::ALT_TEXT_LENGTH_LIMIT;

        foreach ($this->getAllElements('img') as $img) {
			global $alt_text_length_limit;
			if ($img->hasAttribute('alt') && strlen($img->getAttribute('alt')) > $limit)
				$this->setIssue($img);
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}