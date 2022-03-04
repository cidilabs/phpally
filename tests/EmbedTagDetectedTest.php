<?php

use CidiLabs\PhpAlly\Rule\EmbedTagDetected;

class EmbedTagDetectedTest extends PhpAllyTestCase {
    public function testCheckFalse()
    {
        $html = '<embed src = "/html/yourfile.swf" width = "200" height = "200">
        </embed><noembed><img src = "yourimage.gif" alt = "Alternative Media"></noembed>';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new EmbedTagDetected($dom);

        $this->assertEquals(1, $rule->check(), 'Embed Tag Detected should have one issues.');
    }
}