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

    public function testCheckRedirectedAndMetadata()
    {
        $html = '<div><a href="https://online.ucf.edu/udoit">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BrokenRedirectedLink($dom);

        // Check if metadata is present with a new link
        $result = $rule->check();
        if ($rule->getIssues() && count($rule->getIssues()) == 1) {
            $meta = $rule->getIssues()[0]->getMetadata();
            $result = 1 + $result;
        }

        $this->assertEquals(2, $result, 'Broken or Redirected Link should have one issue.');
    }
}
