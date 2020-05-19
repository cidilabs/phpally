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
    public static $severity = self::SEVERITY_SUGGESTION;
    var $strings = array('en' => array('click here', 'click', 'more', 'here'),
    'es' => array('clic aqu&iacute;', 'clic', 'haga clic', 'm&aacute;s', 'aqu&iacute;'));
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('a') as $a) {
            if (in_array(strtolower(trim($a->nodeValue)), $this->translation()) || $a->nodeValue == $a->getAttribute('href'))
				$this->setIssue($a);
        }

        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}