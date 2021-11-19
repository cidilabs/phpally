<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  All embed elements have an associated noembed element that contains a text equivalent to the embed element.
*  Provide a text equivalent for the embed element.
*/
class EmbedHasAssociatedNoEmbed extends BaseRule
{
    
    
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
            $this->totalTests++;
		}
        
        return count($this->issues);
    }

}