<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use CidiLabs\PhpAlly;
use CidiLabs\PhpAlly\Vimeo;
use CidiLabs\PhpAlly\Youtube;
use GuzzleHttp\Client;

/**
*	Links to YouTube videos must have a caption
*/
class VideosEmbeddedOrLinkedNeedCaptions extends BaseRule
{
    
    
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
					$service = new Youtube(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang);
				}
				elseif ( preg_match($search_vimeo, $attr_val) ) {
					$service = new Vimeo(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang);
				}
				if (isset($service)) {
                    $captionState = $service->captionsMissing($attr_val);
					if($captionState != 2) {
						$this->setIssue($video);
					}
				}
			}
		}
        
        return count($this->issues);
    }

}