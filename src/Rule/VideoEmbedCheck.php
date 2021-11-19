<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*	Videos need to be accessible
*/
class VideoEmbedCheck extends BaseRule
{
    
    
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
            $this->totalTests++;

        }

		foreach ($this->getAllElements('a') as $link) {
			if (preg_match($search, $link->getAttribute('href'))) {
				$this->setIssue($link);
			}
            $this->totalTests++;

        }

		foreach ($this->getAllElements('object') as $object) {
			if (preg_match($search, $object->getAttribute('data'))) {
				$this->setIssue($object);
			}
            $this->totalTests++;

        }
        
        return count($this->issues);
    }

}