<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
* 
*  CUSTOM TEST FOR UDOIT
*  Checks if content is using the proper heading hierarchy
*/
class HeadingsInOrder extends BaseRule
{
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        
        return count($this->issues);
    }

}