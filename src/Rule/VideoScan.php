<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*	
*/
class VideoScan extends BaseRule
{

    const YOUTUBE_VIDEO = 2;
    const VIMEO_VIDEO = 3;
    CONST KALTURA_VIDEO = 4;

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
                $provider = $this->getVideoProvider($attr_val);
                $captionData = $this->getCaptionData($attr_val, $provider);
                
                if($captionData) {
                    
                }

			}
		}
    }

    public function getCaptionData($url, $provider)
    {
		if ($provider === self::YOUTUBE_VIDEO) {
			if (!empty($this->options['youtubeApiKey'])) {
				$service = new Youtube(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['youtubeApiKey']);
			}
		} elseif ($provider === self::VIMEO_VIDEO) {
			if (!empty($this->options['vimeoApiKey'])) {
				$service = new Vimeo(new \GuzzleHttp\Client(['http_errors' => false]), $this->lang, $this->options['vimeoApiKey']);
			}
		} else if ($provider === self::KALTURA_VIDEO) {
			if (!empty($this->options['kalturaApiKey'])) {
				$service = new Kaltura($this->lang, $this->options['kalturaApiKey'], $this->options['kalturaUsername']);
			}
		}
		if (isset($service)) {
			// make API call
		}

		return false;
    }

    public function getVideoProvider($url)
    {
        $search_youtube = '/(youtube|youtu.be)/';
		$search_vimeo = '/(vimeo)/';
		$search_kaltura = '/(kaltura)/';

        if (preg_match($search_youtube, $url)) {
			return self::YOUTUBE_VIDEO;
		} elseif (preg_match($search_vimeo, $url)) {
			return self::VIMEO_VIDEO;
		} else if (preg_match($search_kaltura, $url)) {
			return self::KALTURA_VIDEO;
		}

        return false;
    }


}