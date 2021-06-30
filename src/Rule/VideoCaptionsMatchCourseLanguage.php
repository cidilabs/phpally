<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use CidiLabs\PhpAlly;
use CidiLabs\PhpAlly\Vimeo;
use CidiLabs\PhpAlly\Youtube;
use GuzzleHttp\Client;

/**
*	Videos with manual captions should have some that match the course language
*/
class VideoCaptionsMatchCourseLanguage extends BaseRule
{
	const VIDEO_HAS_CAPTIONS = 2;
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
		foreach ($this->getAllElements(array('a', 'embed', 'iframe', 'script')) as $video) {
			$attr = ($video->tagName == 'a') ? 'href' : 'src';
			if ($video->hasAttribute($attr)) {
				$attr_val = $video->getAttribute($attr);
				$captionState = $this->getCaptionState($attr_val);
				if ($captionState != self::VIDEO_HAS_CAPTIONS) {
					$this->setIssue($video);
				}
			}
		}
        
        return count($this->issues);
    }

	public function getCaptionState($attr_val)
	{
		$search_youtube = '/(youtube|youtu.be)/';
		$search_vimeo = '/(vimeo)/';
		$search_kaltura = '/(kaltura)/';

		if (preg_match($search_youtube, $attr_val)) {
			$service = new Youtube(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['youtubeApiKey']);
		} elseif (preg_match($search_vimeo, $attr_val)) {
			$service = new Vimeo(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['vimeoApiKey']);
		} else if (preg_match($search_kaltura, $attr_val)) {
			$service = new Kaltura($this->lang, $this->options['kalturaApiKey'], $this->options['kalturaUsername']);
		}
		if (isset($service)) {
			$captionState = $service->captionsLanguage($attr_val);
			return $captionState;
		}

		return self::VIDEO_HAS_CAPTIONS;
	}
}