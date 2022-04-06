<?php

namespace CidiLabs\PhpAlly;

use DOMElement;
use DOMDocument;

class PhpAllyIssue implements \JsonSerializable {
    protected $ruleId;
    protected $element;
    protected $previewElement;

    public function __construct($ruleId, DOMElement $element = null, DOMElement $previewElement = null, $metadata = null)
    {
        $this->ruleId = $ruleId;
        $this->element = $this->prepareElement($element);
        $this->metadata = $metadata;

        if (!is_null($previewElement)) {
            $this->previewElement = $this->prepareElement($previewElement);
        }
        else {
            if ($this->element) {
                $this->previewElement = $this->prepareElement($this->element->parentNode);        
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

    public function getMetadata()
    {
        if (!$this->metadata) {
            return '';
        }

        return $this->metadata;
    }

    public function getHtml()
    {
        if (!$this->element) {
            return '';
        }

        return $this->element->ownerDocument->saveHTML($this->element);
    }

    public function getPreview()
    {
        if (!$this->previewElement) {
            return '';
        }

        return $this->element->ownerDocument->saveHTML($this->previewElement);
    }

    public function toArray()
    {
        return [
            'ruleId' => $this->ruleId,
            'html' => $this->getHtml(),
            'preview' => $this->getPreview(),
            'metadata' => $this->getMetadata(),
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

    public function prepareElement($element)
    {
        if($body = $element->getElementsByTagName('body')->item(0)){
            $mock = new DOMDocument;
            $children = $body->childNodes;
            $divNode = null;

            if (count($children) > 1) {
                // Add a wrapper div around the children
                $divNode = $mock->createElement('div');
                foreach ($children as $child){
                    $divNode->appendChild($mock->importNode($child, true));
                }

                $mock->appendChild($divNode);
            } else {
                foreach ($children as $child){
                    $mock->appendChild($mock->importNode($child, true));
                }
            }

            $mock->saveHTML();
            $element = $mock->documentElement;
            print_r($element);
        }
        
        return $element;
    }
}