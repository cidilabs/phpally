<?php

namespace CidiLabs\PhpAlly;

use DOMElement;

class PhpAllyIssue implements \JsonSerializable {
    protected $ruleId;
    protected $element;
    protected $previewElement;

    public function __construct($ruleId, DOMElement $element = null, DOMElement $previewElement = null)
    {
        $this->ruleId = $ruleId;
        $this->element = $element;

        if (!empty($previewElement)) {
            $this->previewElement = $previewElement;
        }
        else {
            if ($this->element) {
                $this->previewElement = $this->element->parentNode;        
            }
        }
    }

    public function getElement()
    {
        return $this->element;
    }

    public function getPreviewElement()
    {
        return $this->previewElement;
    }

    public function getRuleId() 
    {
        return $this->ruleId;
    }

    public function getHtml()
    {
        if (!$this->element) {
            return '';
        }

        //return $this->element->ownerDocument->saveHTML($this->element);
        return $this->element->ownerDocument->saveXML($this->element);
    }

    public function getPreview()
    {
        if (!$this->element) {
            return '';
        }

        //return $this->element->ownerDocument->saveHTML($this->previewElement);
        return $this->element->ownerDocument->saveXML($this->previewElement);
    }

    public function toArray()
    {
        return [
            'ruleId' => $this->ruleId,
            'html' => $this->getHtml(),
            'preview' => $this->getPreview(),
        ];
    }
    
    public function __toString()
    {
        return \json_encode($this->toArray());
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}