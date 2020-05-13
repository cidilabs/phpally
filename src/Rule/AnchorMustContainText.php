<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Each source anchor contains text.
*  a (anchor) element must contain text. The text may occur in the anchor text or in the title attribute of the anchor or in the Alt text of an image used within the anchor.
*	@link http://quail-lib.org/test-info/aMustContainText
*/
class AnchorMustContainText extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('a') as $a) {
            if (!$this->elementContainsReadableText($a) && ($a->hasAttribute('href'))) {
                $this->setIssue($a);
            }
        }

        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}