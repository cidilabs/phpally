<?php

use CidiLabs\PhpAlly\Rule\BrokenLink;

class BrokenLinkTest extends PhpAllyTestCase {
    public function testCheckValid()
    {
        $html = '<div><a href="www.google.com">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenLink($dom);

        $this->assertEquals(0, $rule->check(), 'BrokenLink should have no issue.');
    }

    public function testCheckBroken400()
    {
        $html = '<div><a href="http://www.deadlinkcity.com/error-page.asp?e=404
        ">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenLink($dom);

        $this->assertEquals(1, $rule->check(), 'BrokenLink should have one issue.');
    }

    public function testCheckBroken404()
    {
        $html = '<div><a href="https://webaim.org/brokenlink">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenLink($dom);

        $this->assertEquals(1, $rule->check(), 'BrokenLink should have one issue.');
    }
}
