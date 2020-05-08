<?php

namespace CidiLabs\PhpAlly;

use DOMElement;

interface PhpAllyRuleInterface {
    public function id();
    public function check();
    public function getPreviewElement(DOMElement $elem = null);
}