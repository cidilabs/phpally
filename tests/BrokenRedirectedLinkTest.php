<?php

use CidiLabs\PhpAlly\Rule\BrokenRedirectedLink;

class BrokenRedirectedLinkTest extends PhpAllyTestCase {
    public function testCheckBroken()
    {
        $html = '<div><a href="https://webaim.org/brokenlink">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenRedirectedLink($dom);

        $this->assertEquals(1, $rule->check(), 'Broken or Redirected Link should have one issue.');
    }

    public function testCheckNotRedirected()
    {
        $html = '<div><a href="www.google.com">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenRedirectedLink($dom);

        $this->assertEquals(0, $rule->check(), 'Broken or Redirected Link should have no issue.');
    }

    public function testCheckRedirected()
    {
        $html = '<div><a href="https://online.ucf.edu/udoit">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenRedirectedLink($dom);

        $this->assertEquals(1, $rule->check(), 'Broken or Redirected Link should have one issue.');
    }
}
