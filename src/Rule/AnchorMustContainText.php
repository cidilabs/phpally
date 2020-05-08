<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

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