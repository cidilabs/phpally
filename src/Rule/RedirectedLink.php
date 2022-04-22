<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Links that are permanently redirected should be updated with the new link.
*  Based on UDOIT 2.8.X https://github.com/ucfopen/UDOIT/blob/classic/lib/Udoit.php
*  contributions by Emily Sachs
*/
class RedirectedLink extends BaseRule
{

	public function id()
	{
		return self::class;
	}

	public function check()
	{
		foreach ($this->getAllElements('a') as $a) {
			$href = $a->getAttribute('href');
			if ($href) {
				$this->checkLink($a, $href);
			}
            $this->totalTests++;

        }
		$this->checkLink($links);

		return count($this->issues);
	}

	private function checkLink($element, $link) {
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $link);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_REFERER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 2);
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

		curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
		// If the status is 400 or greater the link is broken so dont bother checking.
		if ($status < 400) {
			$this->checkRedirect($element);
		}
		
		curl_close($curl);
	}

	private function checkRedirect($original) {
		$link = $original->getAttribute('href');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $link);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_REFERER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 2);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_exec($curl);
		$redirect = curl_getinfo($curl, CURLINFO_REDIRECT_URL);
		$status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
		curl_close($curl);

		// Only permanent redirections are a problem
		if ($status === 301 || $status === 308) {
			$this->followPermanentRedirects($original, $redirect); 
		}
	}

	private function followPermanentRedirects($original, $link, $maxRedirects = 20) {
		// Avoid infinite calls. 20 is chrome and firefox redirect limit.
		if ($maxRedirects < 1) {
			$this->setIssue($original, null, json_encode(array('redirect_url' => $link)));
			return;
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $link);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_REFERER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 2);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_exec($curl);
		$redirect = curl_getinfo($curl, CURLINFO_REDIRECT_URL);
		$status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
		curl_close($curl);

		// Continue until we run out of permanent redirects
		if ($status === 301 || $status === 308) {
			$this->followPermanentRedirects($original, $redirect, $maxRedirects - 1);
		} else {
			$this->setIssue($original, null, json_encode(array('redirect_url' => $link)));
		}
	}
}

