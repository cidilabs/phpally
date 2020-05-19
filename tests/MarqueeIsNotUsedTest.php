<?php

use CidiLabs\PhpAlly\Rule\MarqueeIsNotUsed;

class MarqueeIsNotUsedTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<!DOCTYPE html><body>
        </body>';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new MarqueeIsNotUsed($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<!DOCTYPE html><body>
        <marquee direction="down" height="100" width="200" bgcolor="white">Scrolling text</marquee>
        </body>';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new MarqueeIsNotUsed($dom);

        $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have one issue.');
    }
}