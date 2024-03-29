<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Alt text for all input elements with a type attribute value of "image" contains all non decorative text in the image.
*  This error is generated for all input elements that have a type of "image".
*	@link http://quail-lib.org/test-info/inputImageNotDecorative
*/
class InputImageNotDecorative extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('input') as $input) {
			if ($input->getAttribute('type') == 'image')
				$this->setIssue($input);
            $this->totalTests++;

        }
        
        return count($this->issues);
    }

}