<?php

use CidiLabs\PhpAlly\Rule\ContentTooLong;

class ContentTooLongTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p><a href="https://cnn.com">Valid Link</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ContentTooLong($dom);

        $this->assertEquals(0, $rule->check(), 'Content Too Long should have no issues.');
    }

    public function testCheckTrueMultipleElements()
    {
        $html = file_get_contents(__DIR__ . '/../tests/testFiles/ContentTooLongValidPage.html');
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ContentTooLong($dom);

        $this->assertEquals(0, $rule->check(), 'Content Too Long should have no issues.');
    }

    public function testCheckFalseOneElement()
    {
        $html = file_get_contents(__DIR__ . '/../tests/testFiles/ContentTooLong.html');
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ContentTooLong($dom);

        $this->assertEquals(1, $rule->check(), 'Content Too Long should have one issue.');
    }

    public function testCheckFalseMultipleElements()
    {
        $html = file_get_contents(__DIR__ . '/../tests/testFiles/ContentTooLongMultipleElements.html');
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ContentTooLong($dom);

        $this->assertEquals(1, $rule->check(), 'Content Too Long should have one issue.');
    }

    public function testCheckSkipScriptTags()
    {
        $html = file_get_contents(__DIR__ . '/../tests/testFiles/ContentTooLongValidPage.html');
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ContentTooLong($dom);

        $this->assertEquals(0, $rule->check(), 'Content Too Long should have no issues.');
    }
}