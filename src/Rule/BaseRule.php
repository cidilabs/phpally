<?php

namespace CidiLabs\PhpAlly\Rule;

use CidiLabs\PhpAlly\PhpAllyIssue;
use CidiLabs\PhpAlly\PhpAllyRuleInterface;
use DOMDocument;
use DOMElement;

class BaseRule implements PhpAllyRuleInterface {

    protected $dom;
    protected $previewHtml = '';
    protected $css = '';
    protected $issues = [];
    protected $errors = [];

    const SEVERITY_ERROR = 'error';
    const SEVERITY_SUGGESTION = 'suggestion';

    public function __construct(DOMDocument $dom, $css = '')
    {
        $this->dom = $dom;
        $this->css = $css;
    }

    public function id()
    {
        return self::class;
    }

    public function getCss()
    {

    }

    public function setCss($css)
    {

    }

    public function check()
    {
        return true;
    }

    public function getPreviewElement(DOMElement $elem = null)
    {
        return null;
    }

    public function getAllElements($tags)
    {
        $result = [];
        
        if (!is_array($tags)) {
            $tags = array($tags);
        }        

        foreach ($tags as $tag) {
            $elements = $this->dom->getElementsByTagName($tag);
            if ($elements) {
                foreach ($elements as $element) {
                    $result[] = $element;
                }
            }
        }
        
        return $result;
    }

    public function elementContainsReadableText($element)
    {
        if (is_a($element, 'DOMText')) {
            if (trim($element->wholeText) != '') {
                return true;
            }
        } else {
            if (trim($element->nodeValue) != '' ||
                ($element->hasAttribute('alt') && trim($element->getAttribute('alt')) != '')
            ) {
                return true;
            }
            if (method_exists($element, 'hasChildNodes') && $element->hasChildNodes()) {
                foreach ($element->childNodes as $child) {
                    if ($this->elementContainsReadableText($child)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function setIssue($element)
    {
        $this->issues[] = new PhpAllyIssue($this->id(), $element, $this->getPreviewElement($element));
    }

    public function getIssues()
    {
        return $this->issues;
    }

    public function setError($errorMsg) 
    {
        $this->errors[] = $errorMsg;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}