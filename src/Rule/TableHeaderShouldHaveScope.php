<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
* 
*/
class TableHeaderShouldHaveScope extends BaseRule
{
    
    
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('th') as $th) {
			if ($th->hasAttribute('scope')) {
				if ($th->getAttribute('scope') != 'col' && $th->getAttribute('scope') != 'row') {
					$this->setIssue($th, $this->getPreviewElement($th));
				}
			} else {
				$this->setIssue($th, $this->getPreviewElement($th));
			}
		}
        
        return count($this->issues);
    }

    public function getPreviewElement(DOMElement $a = null)
    {   
        while(property_exists($a, 'parentNode') && in_array($a->parentNode->tagName, ['tr', 'th', 'table'])){
            $a = $a->parentNode;

            if(property_exists($a, 'tagName')) {
                if($a->tagName === 'table') {
                    Break;
                }
            }
            
        }

        return $a;
    }

}