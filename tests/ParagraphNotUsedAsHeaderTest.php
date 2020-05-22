<?php

use CidiLabs\PhpAlly\Rule\ParagraphNotUsedAsHeader;

class ParagraphNotUsedAsHeaderTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p>Hey</p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ParagraphNotUsedAsHeader($dom);

        $this->assertEquals(0, $rule->check(), 'Paragraph Not Used As Header should have no issues.');
    }

    public function testCheckTrueParagraphInTableHeader()
    {
        $html = '<div><th><p><strong>Hey</strong></p></th></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ParagraphNotUsedAsHeader($dom);

        $this->assertEquals(0, $rule->check(), 'Paragraph Not Used As Header should have one issue.');
    }

    public function testCheckFalsePUsedAsHeader()
    {
        $html = '<div><p><strong>Hey</strong></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ParagraphNotUsedAsHeader($dom);

        $this->assertEquals(1, $rule->check(), 'Paragraph Not Used As Header should have one issue.');
    }

    public function testCheckFalseBoldUsed()
    {
        $html = '<div><p style="font-weight:bold;">Hey</p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ParagraphNotUsedAsHeader($dom);

        $this->assertEquals(1, $rule->check(), 'Paragraph Not Used As Header should have one issue.');
    }
}