<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*	HTML5 video tags have captions.
*/
class VideoProvidesCaptions extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('video') as $video) {
			if (!$this->elementHasChild($video, 'track')) {
				$this->setIssue($video);
			}
		}
        
        return count($this->issues);
    }

    /**
	*	Returns true if an element has a child with a given tag name
	*	@param object $element A DOMElement object
	*	@param string $child_tag The tag name of the child to find
	*	@return bool TRUE if the element does have a child with
	*				 the given tag name, otherwise FALSE
	*/
	public function elementHasChild(DOMElement $element, $child_tag) {
		foreach($element->childNodes as $child) {
			if(property_exists($child, 'tagName') && $child->tagName == $child_tag)
				return true;
		}
		return false;
	}

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}