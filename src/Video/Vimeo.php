<?php

namespace CidiLabs\PhpAlly\Video;

use GuzzleHttp\Client;

class Vimeo
{
	const VIMEO_FAILED_CONNECTION = -1;
	const VIMEO_FAIL = 0;	
	const VIMEO_SUCCESS = 1;
	const PROVIDER_NAME = "Vimeo";

	private $regex = '@vimeo\.com/[^0-9]*([0-9]{7,9})@i';
	private $search_url = 'https://api.vimeo.com/videos/';
	private $client;
	private $language;

	public function __construct(Client $client, $language, $api_key)
	{
		$this->client = $client;
		$this->language = $language;
		$this->api_key = $api_key;
	}

	/**
	 *	Checks to see if a video is missing caption information in Vimeo
	 *	@param array $captions
	 *   @return int 
	 */
	function captionsMissing($captions)
	{
		return !empty($captions) ? self::VIMEO_SUCCESS : self::VIMEO_FAIL;
	}

	/**
	 *	Checks to see if a video is missing caption information in Vimeo
	 *	@param array $captions
	 *	@return int 
	 */
	function captionsLanguage($captions)
	{
		// If for whatever reason course_locale is blank, set it to English
		$course_locale = ($this->language) ? substr(strtolower($this->language), 0, 2) : 'en';

		foreach ($captions as $track) {
			if (substr(strtolower($track->language), 0, 2) === $course_locale) {
				return self::VIMEO_SUCCESS;
			}
		}

		return empty($captions) ? self::VIMEO_SUCCESS : self::VIMEO_FAIL;
	}

	/**
	 *	Checks to see if the provided link URL is a Vimeo video. If so, it returns
	 *	the video code, if not, it returns null.
	 *	@param string $link_url The URL to the video or video resource
	 *	@return mixed FALSE if it's not a Vimeo video, or a string video ID if it is
	 */
	private function isVimeoVideo($link_url)
	{
		$matches = null;
		if (preg_match($this->regex, trim($link_url), $matches)) {
			return $matches[1];
		}
		return false;
	}

	/**
	 *	Gets the caption data from the youtube api
	 *	@param string $link_url The URL to the video or video resource
	 *	@return mixed $response Returns response object if api call can be made, null otherwise
	 */
	function getVideoData($link_url) 
	{
		$key_trimmed = trim($this->api_key);
		$vimeo_id = $this->isVimeoVideo($link_url);
	
		if (!$vimeo_id || empty($key_trimmed)) {
			return self::VIMEO_FAILED_CONNECTION;
		}

		$url = $this->search_url . $vimeo_id . '/texttracks';

		$response = $this->client->request('GET', $url, ['headers' => [
			'Authorization' => "Bearer $this->api_key"
		]]);

		if ($response->getStatusCode() >= 400) {
			return self::VIMEO_FAILED_CONNECTION;
		}

		$result = json_decode($response->getBody());
		
		return isset($result->data) ? $result->data : self::VIMEO_FAILED_CONNECTION;
	}

	public function getName() {
		return self::PROVIDER_NAME;
	}
}
