<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*
*/
class BrokenRedirectedLink extends BaseRule
{


	public function id()
	{
		return self::class;
	}

	public function check()
	{
		foreach ($this->getAllElements('a') as $a) {
			$link = $a->getAttribute('href');
			if ($link) {
				$this->setIssue($a);
			}
		}

		return count($this->issues);
	}

}
