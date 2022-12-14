<?php

namespace CidiLabs\PhpAlly\Rule;

/**
 *	Checks that all colored background elements are also bold or italicized
 */
class CssTextStyleEmphasize extends BaseRule
{
	public static $blockElements = [
		'p', 
		'td', 
		'div', 
		'li',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
	];

	public static $genericTextElements = [
		'span',
		'font',
	];

	public static $emphasizedTextElements = [
		'b',
		'strong',
		'em',
		'small',
		'sup',
		'sub',
		'a',
	];

	public function id()
	{
		return self::class;
	}

	public function check()
	{
		/**
		 * Select all generic text elements.
		 * Check if they have a style attribute.
		 * Check if style attribute applies a color or background-color.
		 * 
		 * We aren't doing any checks on color contrast here. 
		 */

		foreach ($this->getAllElements(self::$genericTextElements) as $element) {
			$styles = $this->getNodeStyle($element);
			$elementText = trim($element->textContent);

			if (!isset($styles['background-color']) && !isset($styles['color'])) {
				continue;
			}
			if (isset($styles['font-weight']) || isset($styles['font-style'])) {
				continue;
			}

			// skip if the element only contains whitespace
			if(!$elementText) {
				continue;
			}

			// skip if parent text == element text AND parent element is emphasized
			$parentNode = $element->parentNode;
			if ($parentNode && ($parentNode->nodeType === XML_ELEMENT_NODE)) {
				$parentText = trim($parentNode->textContent);

				if ($parentText == $elementText) {
					if (in_array($parentNode->tagName, self::$emphasizedTextElements)) {
						continue;
					}
					if (in_array($parentNode->tagName, self::$blockElements)) {
						continue;
					}
				}
			}
			
			// skip if child text == element text AND child is emphasized
			$childNode = (isset($element->nodeValue) && isset($element->firstChild->nodeValue)) ? $element->firstChild : null;
			if ($childNode && $childNode->nodeType === XML_ELEMENT_NODE) {
				$childText = trim($childNode->textContent);

				if ($childText == $elementText) {
					if (in_array($childNode->tagName, self::$emphasizedTextElements)) {
						continue;
					}
				}
			}

			$this->setIssue($element);
            $this->totalTests++;
		}

		return count($this->issues);
	}
}
