<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  All img elements must have an alt attribute. Duh!
*	@link http://quail-lib.org/test-info/imgHasAlt
*/
class ImageHasAlt extends BaseRule
{


    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if (!$img->hasAttribute('alt') || trim($img->getAttribute('alt')) == '') {
                if(!($img->hasAttribute('role') && $img->getAttribute('role') == 'presentation')
                && !($img->hasAttribute('data-decorative') && $img->getAttribute('data-decorative') == 'true')) {
					$this->setIssue($img);
				}
			}
			$this->totalTests++;
        }

        return count($this->issues);
    }

}
