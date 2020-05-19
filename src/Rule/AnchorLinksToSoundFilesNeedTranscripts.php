<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Sound file must have a text transcript.
*  a (anchor) element cannot contain an href attribute value that ends with any of the following (all case insensitive): .wav, .snd, .mp3, .iff, .svx, .sam, .smp, .vce, .vox, .pcm, .aif.
*	@link http://quail-lib.org/test-info/aLinksToSoundFilesNeedTranscripts
*/
class AnchorLinksToSoundFilesNeedTranscripts extends BaseRule
{
    public static $severity = self::SEVERITY_SUGGESTION;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        /**
        *	@var array $extensions A list of extensions that mean this file is a link to audio
        */
        $extensions = ['wav', 'snd', 'mp3', 'iff', 'svx', 'sam', 'smp', 'vce', 'vox', 'pcm', 'aif'];

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