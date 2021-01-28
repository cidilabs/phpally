<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
*  All p elements are not used as headers.
*  All p element content must not be marked with either b, u, strong, font.
*  TODO: Revisit how to tie this in with css.php with this new implementation
*/
class ParagraphNotUsedAsHeader extends BaseRule
{
	
	
	var $head_tags = array('strong', 'font', 'b', 'u');
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
		foreach ($this->getAllElements('p') as $p) {
			$parent_tag = isset($p->parentNode->tagName) ? $p->parentNode->tagName : false;
			
			if($parent_tag != 'td' && $parent_tag != 'th') {
				if (isset($p->nodeValue) && isset($p->firstChild->nodeValue)) {
					
					if (($p->nodeValue == $p->firstChild->nodeValue)
						&& is_object($p->firstChild)
						&& property_exists($p->firstChild, 'tagName')
						&& in_array($p->firstChild->tagName, $this->head_tags)) {
						$this->setIssue($p);
					} 
					
					else {
						$style = $this->parseCSS($p->getAttribute('style'));

						if(isset($style['font-weight'])) {
							if ($style['font-weight'] == 'bold') {
								$this->setIssue($p);
							}
						}
					}
				}
			}
		}

        
        return count($this->issues);
    }

	public function parseCSS($css) {
		$results = array();
		preg_match_all("/([\w-]+)\s*:\s*([^;]+)\s*;?/", $css, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			$results[$match[1]] = $match[2];
		}

		return $results;
	}
}