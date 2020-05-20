<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*	Videos need to be accessible
*/
class VideoEmbedCheck extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $search = '/(dailymotion)/';

		foreach ($this->getAllElements('iframe') as $iframe) {
			if (preg_match($search, $iframe->getAttribute('src'))) {
				$this->setIssue($iframe);
			}
		}

		foreach ($this->getAllElements('a') as $link) {
			if (preg_match($search, $link->getAttribute('href'))) {
				$this->setIssue($link);
			}
		}

		foreach ($this->getAllElements('object') as $object) {
			if (preg_match($search, $object->getAttribute('data'))) {
				$this->setIssue($object);
			}
		}
        
        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}