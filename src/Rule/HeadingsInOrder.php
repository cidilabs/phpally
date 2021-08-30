<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;
use DOMXPath;

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
        $xpath = new DOMXPath($this->dom);
        $headings = $xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');

        // Check that we dont skip heading levels.
        for ($i = 0; $i < count($headings); $i++) {
            $currentLevel = (int)substr($headings[$i]->nodeName, -1);

            // Check that we start with the right heading.
            if ($i === 0) {
                if ($currentLevel !== 1 && $currentLevel !== 2) {
                    $this->setIssue($headings[$i]);
                }
            } elseif ($currentLevel > ($previousLevel + 1)) {
                $this->setIssue($headings[$i]);
            }

            $previousLevel = $currentLevel;
        }

        return count($this->issues);
    }

}
