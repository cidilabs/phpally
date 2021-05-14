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
        foreach ($this->getAllElements('table') as $table) {
            $missingScope = false;

            foreach ($table->childNodes as $child) {
                if ($this->propertyIsEqual($child, 'tagName', 'tbody') || $this->propertyIsEqual($child, 'tagName', 'thead')) {
                    foreach ($child->childNodes as $tr) {
                        if ($this->rowMissingScope($tr)) {
                            $missingScope = true;
                            break 2;
                        }
                    }
                } elseif ($this->propertyIsEqual($child, 'tagName', 'tr')) {
                    if ($this->rowMissingScope($child)) {
                        $missingScope = true;
                        break;
                    }
                }
            }

            if ($missingScope) {
                $this->setIssue($table);
                $this->setPreviewElement($table);
            }
        }

        return count($this->issues);
    }

    public function rowMissingScope($row)
    {
        if (!is_null($row->childNodes)) {
            foreach ($row->childNodes as $th) {
                if ($th->nodeType === XML_TEXT_NODE) {
                    continue;
                }
                if (!$this->propertyIsEqual($th, 'tagName', 'th')) {
                    continue;
                }

                if ($th->hasAttribute('scope')) {
                    if ($th->getAttribute('scope') != 'col' && $th->getAttribute('scope') != 'row') {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }

        return false;
    }
}
