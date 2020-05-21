<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use CidiLabs\PhpAlly;

/**
*	Links to YouTube videos must have a caption
*/
class VideoEmbeddedOrLinkedNeedCaptions extends BaseRule
{
    public static $severity = self::SEVERITY_ERROR;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $search_youtube = '/(youtube|youtu.be)/';
		$search_vimeo = '/(vimeo)/';

		foreach ($this->getAllElements(array('a', 'embed', 'iframe')) as $video) {
			$attr = ($video->tagName == 'a') ? 'href' : 'src';
			if ($video->hasAttribute($attr)) {
				$attr_val = $video->getAttribute($attr);
				if ( preg_match($search_youtube, $attr_val) ) {
					$service = new Youtube(new Client(), $attr_val, $this->googleApiKey);
				}
				elseif ( preg_match($search_vimeo, $attr_val) ) {
					$service = new Vimeo(new Client(), $attr_val, $this->vimeoApiKey);
				}
				if (isset($service)) {
                    $captionState = $service->captionsMissing();
					if($captionState != 2) {
						$this->setIssue($video);
					}
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