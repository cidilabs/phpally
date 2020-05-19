<?php

use CidiLabs\PhpAlly\Rule\PreShouldNotBeUsedForTabularValues;

class PreShouldNotBeUsedForTabularValuesTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><pre>Text in a pre element is displayed in a fixed-width font, and it preserves both spaces and line breaks</pre></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new PreShouldNotBeUsedForTabularValues($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><pre>
        Text in a pre element
        is displayed in a fixed-width
        font, and it preserves
        both spaces and line breaks
        </pre></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new PreShouldNotBeUsedForTabularValues($dom);

        $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have one issue.');
    }
}