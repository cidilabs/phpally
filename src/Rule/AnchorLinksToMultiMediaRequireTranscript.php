<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

class AnchorLinksToMultiMediaRequireTranscript extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        /**
        *	@var array $extensions A list of extensions that mean this file is a link to audio
        */
        $extensions = ['wmv', 'mpg', 'mov', 'ram', 'aif'];

        foreach ($this->getAllElements('a') as $a) {
			if ($a->hasAttribute('href')) {
				$filename  = explode('.', $a->getAttribute('href'));
				$extension = array_pop($filename);

				if (in_array($extension, $extensions)) {
					$this->setIssue($a);
				}
			}
		}

        return count($this->issues);
    }

    // public function getPreviewElement(DOMElement $a = null)
    // {
    //     return $a->parentNode;
    // }
}