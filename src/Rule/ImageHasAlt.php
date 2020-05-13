<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

class ImageHasAlt extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if (!$img->hasAttribute('alt')
				|| $img->getAttribute('alt') == ''
				|| $img->getAttribute('alt') == ' ') {
				if(!($img->hasAttribute('data-decorative')
					&& $img->getAttribute('data-decorative') == 'true')) {
					$this->setIssue($img);
				}
			}
        }
        
        return count($this->issues);
    }
}