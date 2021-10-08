<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Links that are broken need to be removed or manually updated.
*  Links that are redirected should be updated with the new link.
*  Based on UDOIT 2.8.X https://github.com/ucfopen/UDOIT/blob/classic/lib/Udoit.php
*  contributions by Emily Sachs
*/
class BrokenRedirectedLink extends BaseRule
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
			curl_setopt($curls[$i], CURLOPT_AUTOREFERER, true);
			curl_setopt($curls[$i], CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curls[$i], CURLOPT_FOLLOWLOCATION, true);
			curl_multi_add_handle($mcurl, $curls[$i]);
		}
		$running = null;
		do {
			curl_multi_exec($mcurl, $running);
		} while ($running > 0);
		foreach (array_keys($links) as $i => $link) {
			$redirect = curl_getinfo($curls[$i], CURLINFO_EFFECTIVE_URL);
			$status = curl_getinfo($curls[$i], CURLINFO_HTTP_CODE);
			if ($link != $redirect) {
				// Redirected link (May be a Canvas link that is not actually redirected)
				$ref = $redirect;
				preg_match('/^[^#\s]+/', $ref, $matches);
				$base = $matches[0];
				$base = preg_replace('/\/$/', '', $base);
				$base = preg_replace('/www\./', '', $base);
				$base = preg_replace('/http[s]{0,1}:\/\//', '', $base);
				if (strpos($link, $base) === false) {
					$this->setIssue($links[$link], null, json_encode(array('redirect_url' => $redirect)));
				}
			}
			if (404 == $status) {
				$this->setIssue($links[$link]);
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
				$links[$href] = $a; // href should exclude start with '#'
			}
		}
		$this->linkCheck($links);

		return count($this->issues);
	}
}
