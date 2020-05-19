<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Decorative imgs should not have an alt attribute
*/
class ImageHasAltDecorative extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if($img->hasAttribute('data-decorative')
				&& $img->getAttribute('data-decorative') == 'true'
				&& $img->hasAttribute('alt')
				&& trim($img->getAttribute('alt') != '')) {
				$this->setIssue($img);
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}