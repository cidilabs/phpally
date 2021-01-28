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
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if ($img->hasAttribute('alt') && (strlen($img->getAttribute('alt')) > $this->altTextLengthLimit)) {
                $this->setIssue($img);
            }
		}
        
        return count($this->issues);
    }

}