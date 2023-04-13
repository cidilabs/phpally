<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Suspicious link text.
*  a (anchor) element cannot contain any of the following text (English): \"click here\""
*	@link http://quail-lib.org/test-info/aSuspiciousLinkText
*/
class AnchorSuspiciousLinkText extends BaseRule
{
    
    var $strings = array('en' => array('click here', 'click', 'more', 'here'),
    'es' => array('clic aqu&iacute;', 'clic', 'haga clic', 'm&aacute;s', 'aqu&iacute;'));
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('a') as $a) {

            // Check to see if the link text is a url
            $textIsLink = ($a->nodeValue == $a->getAttribute('href')) || str_starts_with($a->nodeValue, "http");

            // Check that the link is not an anchor
            $linkIsAnchor = ($a->getAttribute('href') == "");

            if ((in_array(strtolower(trim($a->nodeValue)), $this->translation()) || $textIsLink) && !$linkIsAnchor )
				$this->setIssue($a);
            $this->totalTests++;
        }

        return count($this->issues);
    }

}