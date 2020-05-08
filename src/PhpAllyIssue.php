<?php

namespace CidiLabs\PhpAlly;

use DOMElement;

class PhpAllyIssue {
    protected $type;
    protected $element;
    protected $previewElement;

    public function __construct($type, DOMElement $element, DOMElement $previewElement = null)
    {
        $this->type = $type;
        $this->element = $element;

        if (!empty($previewElement)) {
            $this->previewElement = $previewElement;
        }
        else {
            $this->previewElement = $this->getPreviewElement();        
        }
    }

    public function getElement()
    {
        return $this->element;
    }

    public function getPreviewElement()
    {
        return $this->element->parentNode;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'html' => $this->element->ownerDocument->saveXML($this->element),
            'preview' => $this->element->ownerDocument->saveXML($this->previewElement),
        ];
    }
    
    public function __toString()
    {
        return \json_encode($this->toArray());
    }
}