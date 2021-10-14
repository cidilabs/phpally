<?php

namespace CidiLabs\PhpAlly\Video;

use CidiLabs\PhpAlly\Vimeo;
use CidiLabs\PhpAlly\Youtube;
use CidiLabs\PhpAlly\Kaltura;

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
		$search_kaltura = '/(kaltura)/';

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
			if (!empty($this->options['youtubeApiKey'])) {
				$service = new Youtube(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['youtubeApiKey']);
			}
		} elseif (preg_match($search_vimeo, $attr_val)) {
			if (!empty($this->options['vimeoApiKey'])) {
				$service = new Vimeo(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['vimeoApiKey']);
			}
		} else if (preg_match($search_kaltura, $attr_val)) {
			if (!empty($this->options['kalturaApiKey'])) {
				$service = new Kaltura($this->lang, $this->options['kalturaApiKey'], $this->options['kalturaUsername']);
			}
		}
		if (isset($service)) {
			$captionState = $service->captionsMissing($attr_val);
			return $captionState;
		}

		return self::VIDEO_HAS_CAPTIONS;
	}
}
