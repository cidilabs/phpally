<?php

namespace CidiLabs\PhpAlly\Rule;

use DOMElement;

/**
 *  All data tables contain th elements.
 *  Data tables must have th elements while layout tables can not have th elements.
 */
class TableDataShouldHaveTableHeader extends BaseRule
{
	

	public function id()
	{
		return self::class;
	}

	public function check()
	{
		foreach ($this->getAllElements('table') as $table) {
			foreach ($table->childNodes as $child) {
				if ($this->propertyIsEqual($child, 'tagName', 'tbody') || $this->propertyIsEqual($child, 'tagName', 'thead')) {
					foreach ($child->childNodes as $tr) {
						if (!is_null($tr->childNodes)) {
							foreach ($tr->childNodes as $th) {
								if ($th->nodeType === XML_TEXT_NODE) {
									continue;
								}
								if ($this->propertyIsEqual($th, 'tagName', 'th')) {
									break 3;
								} else {
									$this->setIssue($table);
									break 3;
								}
							}
						}
					}
				} elseif ($this->propertyIsEqual($child, 'tagName', 'tr')) {
					foreach ($child->childNodes as $th) {
						if ($th->nodeType === XML_TEXT_NODE) {
							continue;
						}
						if ($this->propertyIsEqual($th, 'tagName', 'th')) {
							break 2;
						} else {
							$this->setIssue($table);
							break 2;
						}
					}
				}
			}
            $this->totalTests++;

        }

		return count($this->issues);
	}

	// public function getPreviewElement(DOMElement $a = null)
	// {
	//     return $a->parentNode;
	// }
}
