<?php

namespace CidiLabs\PhpAlly\Rule;

use CidiLabs\PhpAlly\Vimeo;
use CidiLabs\PhpAlly\Youtube;

/**
 *	Links to YouTube videos must have a caption
 */
class VideosEmbeddedOrLinkedNeedCaptions extends BaseRule
{
	const VIDEO_HAS_CAPTIONS = 2;

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
				if (preg_match($search_youtube, $attr_val)) {
					$service = new Youtube(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['youtubeApiKey']);
				} elseif (preg_match($search_vimeo, $attr_val)) {
					$service = new Vimeo(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['vimeoApiKey']);
				}
				if (isset($service)) {
					$captionState = $service->captionsMissing($attr_val);
					if ($captionState != self::VIDEO_HAS_CAPTIONS) {
						$this->setIssue($video);
					}
				}
			}
		}

		return count($this->issues);
	}
}
