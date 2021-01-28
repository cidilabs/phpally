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
					$this->setIssue($th);
				}
			} else {
				$this->setIssue($th);
			}
		}
        
        return count($this->issues);
    }

}