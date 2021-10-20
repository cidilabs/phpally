<?php

use CidiLabs\PhpAlly\Rule\RedirectedLink;

class RedirectedLinkTest extends PhpAllyTestCase {
    public function testCheckNotRedirected()
    {
        $html = '<div><a href="www.google.com">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new RedirectedLink($dom);

        $this->assertEquals(0, $rule->check(), 'RedirectedLink should have no issue.');
    }

    public function testCheckRedirected()
    {
        $html = '<div><a href="https://online.ucf.edu/udoit">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new RedirectedLink($dom);

        $this->assertEquals(1, $rule->check(), 'RedirectedLink should have one issue.');
    }

    public function testCheckRedirectedAndMetadata()
    {
        $html = '<div><a href="https://online.ucf.edu/udoit">I am a link.</a><div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new RedirectedLink($dom);

        // Check if metadata is present with a new link
        $result = $rule->check();
        if ($rule->getIssues() && count($rule->getIssues()) == 1) {
            $meta = $rule->getIssues()[0]->getMetadata();
            $result = 1 + $result;
        }

        $this->assertEquals(2, $result, 'RedirectedLink should have one issue.');
    }
}
