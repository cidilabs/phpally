<?php

use CidiLabs\PhpAlly\Rule\BrokenRedirectedLink;

class BrokenRedirectedLinkTest extends PhpAllyTestCase {
    public function testCheckAlive()
    {
        $html = '<div><a href="https://google.com/">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenRedirectedLink($dom);

        $this->assertEquals(1, $rule->check(), 'Broken or Redirected Link should have one issue.');
    }
}
