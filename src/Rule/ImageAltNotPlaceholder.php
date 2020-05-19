<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Alt text for all img elements is not placeholder text unless author has confirmed it is correct.
*  img element cannot have alt attribute value of "nbsp" or "spacer".
*	@link http://quail-lib.org/test-info/imgAltNotPlaceHolder
*/
class ImageAltNotPlaceholder extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    var $strings = array('en' => array('nbsp', '&nbsp;', 'spacer', 'image', 'img', 'photo'),
	'es' => array('nbsp', '&nbsp;', 'spacer', 'espacio', 'imagen', 'img', 'foto'));
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('img') as $img) {
			if ($img->hasAttribute('alt')) {
				if (strlen($img->getAttribute('alt')) > 0) {
					if (in_array($img->getAttribute('alt'), $this->translation()) || ord($img->getAttribute('alt')) == 194) {
						$this->setIssue($img);
					}
					elseif (preg_match("/^([0-9]*)(k|kb|mb|k bytes|k byte)?$/",
							strtolower($img->getAttribute('alt')))) {
						$this->setIssue($img);
					}
				}
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}