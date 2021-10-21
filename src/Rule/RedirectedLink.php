<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Links that are redirected should be updated with the new link.
*  Based on UDOIT 2.8.X https://github.com/ucfopen/UDOIT/blob/classic/lib/Udoit.php
*  contributions by Emily Sachs
*/
class RedirectedLink extends BaseRule
{

	public function id()
	{
		return self::class;
	}

	private function linkCheck($links) {
		$curls = array();
		$mcurl = curl_multi_init();
		foreach (array_keys($links) as $i => $link) {
			$curls[$i] = curl_init();
			curl_setopt($curls[$i], CURLOPT_URL, $link);
			curl_setopt($curls[$i], CURLOPT_HEADER, true);
			curl_setopt($curls[$i], CURLOPT_NOBODY, true);
			curl_setopt($curls[$i], CURLOPT_REFERER, true);
			curl_setopt($curls[$i], CURLOPT_TIMEOUT, 2);
			curl_setopt($curls[$i], CURLOPT_RETURNTRANSFER, true);
			curl_multi_add_handle($mcurl, $curls[$i]);
		}
		$running = null;
		do {
			curl_multi_exec($mcurl, $running);
		} while ($running > 0);
		foreach (array_keys($links) as $i => $link) {
			$redirect = curl_getinfo($curls[$i], CURLINFO_REDIRECT_URL);
			$status = curl_getinfo($curls[$i], CURLINFO_RESPONSE_CODE);

			// Only permanent redirections are a problem
			if ($status === 301 || $status === 308) {
				$parsed_link = parse_url($link);
				$parsed_redirect = parse_url($redirect);
				if ($parsed_link['host'] !== $parsed_redirect['host'] ||
					$parsed_link['path'] !== $parsed_redirect['path']) {
					$this->setIssue($links[$link], null, json_encode(array('redirect_url' => $redirect)));
				}
			}

			curl_multi_remove_handle($mcurl, $curls[$i]);
		}
		curl_multi_close($mcurl);
	}

	public function check()
	{
		$links = array();
		foreach ($this->getAllElements('a') as $a) {
			$href = $a->getAttribute('href');
			if ($href) {
				$links[$href] = $a;
			}
		}
		$this->linkCheck($links);

		return count($this->issues);
	}
}

