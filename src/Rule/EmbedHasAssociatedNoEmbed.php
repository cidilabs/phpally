<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  All embed elements have an associated noembed element that contains a text equivalent to the embed element.
*  Provide a text equivalent for the embed element.
*/
class EmbedHasAssociatedNoEmbed extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('embed') as $embed) {
			if (!$this->propertyIsEqual($embed->firstChild, 'tagName', 'noembed')
			   && !$this->propertyIsEqual($embed->nextSibling, 'tagName', 'noembed')) {
					$this->setIssue($embed);
			}

		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}