<?php

namespace CidiLabs\PhpAlly;

use DOMElement;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class Youtube {

    private $regex = array(
		'@youtube\.com/embed/([^"\&\? ]+)@i',
	    '@youtube\.com/v/([^"\&\? ]+)@i',
	    '@youtube\.com/watch\?v=([^"\&\? ]+)@i',
	    '@youtube\.com/\?v=([^"\&\? ]+)@i',
	    '@youtu\.be/([^"\&\? ]+)@i',
	    '@youtu\.be/v/([^"\&\? ]+)@i',
	    '@youtu\.be/watch\?v=([^"\&\? ]+)@i',
	    '@youtu\.be/\?v=([^"\&\? ]+)@i',
        );
        
    private $search_url = 'https://www.googleapis.com/youtube/v3/captions?part=snippet&fields=items(snippet(trackKind,language))&videoId=';
	private $client;
	private $language;
    private $link_url;
    private $api_key = 'AIzaSyAVQMyhlUnAjeW1bzmNk49agG966Mwl5Ac';
    
    public function __construct($client)
    {
		$this->client = $client;
    }

    /**
	*	Checks to see if a video is missing caption information in YouTube
	*	@param string $link_url The URL to the video or video resource
	*	@return int 0 if captions are missing, 1 if video is private, 2 if captions exist or not a video
	*/
	public function captionsMissing($link_url)
	{
		$url = $this->search_url;

		// If the API key is blank, flag the video for manual inspection
		$key_trimmed = trim($this->api_key);
		if( empty($key_trimmed) ){
			return 1;
		}

		if( $youtube_id = $this->isYouTubeVideo($link_url) ) {
			$url = $url.$youtube_id.'&key='.$this->api_key;
			$response = $this->client->request('GET', $url);

			// If the video was pulled due to copyright violations, is unlisted, or is unavailable, the reponse header will be 404
			if( $response->getStatusCode() === 404 ) {
				return 1;
			}

			// If the daily limit has been exceeded for our API key or there was some other error
			if( $response->getStatusCode() === 403 ) {
				// global $logger;
				// $logger->addError('YouTube API Error: '.$response->body->error->errors[0]->message);
			}

            $items = json_decode($response->getBody())->items;

			// Looks through the captions and checks if any were not auto-generated
			foreach ($items as $track ) {
				if ( strtolower($track->snippet->trackKind) != 'asr' ) {
					return 2;
				}
			}

			return 0;
		}

		return 2;
	}
	
	/**
	*	Checks to see if a video is missing caption information in YouTube
	*	@param string $link_url The URL to the video or video resource
	*	@return int 0 if captions are manual and wrong language, 1 if video is private, 2 if captions are auto-generated or manually generated and correct language
	*/
	function captionsLanguage($link_url)
	{
		$url = $this->search_url;
		$api_key = $this->api_key;
		$foundManual = false;

		// If the API key is blank, flag the video for manual inspection
		$key_trimmed = trim($api_key);
		if( empty($key_trimmed) ){
			return 1;
		}

		// If for whatever reason course_locale is blank, set it to English
		$course_locale = $this->language;
		if($course_locale === '') {
			$course_locale = 'en';
		}

		if( $youtube_id = $this->isYouTubeVideo($link_url) ) {
			$url = $url.$youtube_id.'&key='.$api_key;
			$response = $this->client->request('GET', $url);

			// If the video was pulled due to copyright violations, is unlisted, or is unavailable, the reponse header will be 404
			if( $response->getStatusCode() === 404 ) {
				return 1;
			}

			// If the daily limit has been exceeded for our API key or there was some other error
			if( $response->getStatusCode() === 403 ) {
				// global $logger;
				// $logger->addError('YouTube API Error: '.$response->body->error->errors[0]->message);
			}

			$items = json_decode($response->getBody())->items;

			// Looks through the captions and checks if they are of the correct language
			foreach ( $items as $track) {
				$trackKind = strtolower($track->snippet->trackKind);

				//If the track was manually generated, set the flag to true
				if( $trackKind != 'asr' ){
					$foundManual = true;
				}

				if( substr($track->snippet->language,0,2) == $course_locale && $trackKind != 'asr' ) {
					return 2;
				}

			}

			//If we found any manual captions and have not returned, then none are the correct language
			if( $foundManual === true ){
				return 0;
			}
		}

			return 2;
	}
    
    /**
	*	Checks to see if the provided link URL is a YouTube video. If so, it returns
	*	the video code, if not, it returns null.
	*	@param string $link_url The URL to the video or video resource
	*	@return mixed FALSE if it's not a YouTube video, or a string video ID if it is
	*/
	private function isYouTubeVideo($link_url)
	{
		$matches = null;
		foreach($this->regex as $pattern) {
			if(preg_match($pattern, trim($link_url), $matches)) {
				return $matches[1];
			}
		}
		return false;
	}
}