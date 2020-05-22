<?php

use CidiLabs\PhpAlly\Rule\BlinkIsNotUsed;

class BlinkIsNotUsedTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><blink>Why would somebody use this?</blink><div>';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BlinkIsNotUsed($dom);

        $this->assertEquals(1, $rule->check(), 'Blink Is Not Used should have one issue.');
    }

    public function testCheckFalse()
    {
        $html = '<div><blink>Why would somebody use this?</blink>';
        $html .= '<blink>Why would somebody use this?</blink></div>';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BlinkIsNotUsed($dom);

        $this->assertEquals(2, $rule->check(), 'Blink Is Not Used should have two issues.');
    }
}