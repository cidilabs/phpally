<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Alt text is not the same as the filename unless author has confirmed it is correct.
*  img element cannot have alt attribute value that is the same as its src attribute.
*	@link http://quail-lib.org/test-info/imgAltIsDifferent
*/
class ImageAltIsDifferent extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if (trim($img->getAttribute('src')) == trim($img->getAttribute('alt')))
				$this->setIssue($img);
			else if ( preg_match("/.jpg|.JPG|.png|.PNG|.gif|.GIF|.jpeg|.JPEG$/", trim($img->getAttribute('alt'))) )
				$this->setIssue($img);
		}
        
        return count($this->issues);
    }

}