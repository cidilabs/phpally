<?php

use CidiLabs\PhpAlly\Rule\BlinkIsNotUsed;

// The loadHTML function doesn't like the blink tag
class BlinkIsNotUsedTest extends PhpAllyTestCase {
    // public function testCheckTrue()
    // {
    //     $html = '<div><blink>Why would somebody use this?</blink><div>';
    //     $dom = new \DOMDocument('1.0', 'utf-8');
    //     $dom->loadHTML($html);
    //     $rule = new BlinkIsNotUsed($dom);

    //     $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have no issues.');
    // }

    // public function testCheckFalse()
    // {
    //     $html = '<div><blink>Why would somebody use this?</blink>';
    //     $html .= '<blink>Why would somebody use this?</blink></div>';
    //     $dom = new \DOMDocument('1.0', 'utf-8');
    //     $dom->loadHTML($html);
    //     $rule = new BlinkIsNotUsed($dom);

    //     $this->assertEquals(2, $rule->check(), 'Object Must Contain Text should have one issue.');
    // }
}