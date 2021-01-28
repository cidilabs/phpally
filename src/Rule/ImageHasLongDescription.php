<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  A long description is used for each img element that does not have Alt text conveying the same information as the image.
*  img element must contain a longdesc attribute.
*	@link http://quail-lib.org/test-info/imgHasLongDesc
*/
class ImageHasLongDescription extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if ($img->hasAttribute('longdesc')) {
				if (trim(strtolower($img->getAttribute('longdesc'))) ==
					trim(strtolower($img->getAttribute('alt')))) {
						$this->setIssue($img);
				}
			}
		}
        
        return count($this->issues);
    }

}