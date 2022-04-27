<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  Links that are broken need to be removed or manually updated.
*  Based on UDOIT 2.8.X https://github.com/ucfopen/UDOIT/blob/classic/lib/Udoit.php
*  contributions by Emily Sachs
*/
class BrokenLink extends BaseRule
{

	public function id()
	{
		return self::class;
	}

	public function check()
	{
		$linkArray = [];
		foreach ($this->getAllElements('a') as $a) {
			$href = $a->getAttribute('href');
			if ($href) {
				if(!in_array($href, $linkArray))
				{
					$this->checkLink($a, $href);
				}
				array_push($linkArray, $href);
			}
            $this->totalTests++;
		}

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
		
		$running = null;
		do {
			curl_exec($curl);
		} while ($running > 0);
			$status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
			// If the status is greater than or equal to 400 the link is broken.
			if ($status >= 400) {
				$this->setIssue($element); 
			}
		curl_close($curl);
	}
}
