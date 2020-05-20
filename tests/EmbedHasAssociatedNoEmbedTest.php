<?php

use CidiLabs\PhpAlly\Rule\EmbedHasAssociatedNoEmbed;

class EmbedHasAssociatedNoEmbedTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<embed src = "/html/yourfile.swf" width = "200" height = "200">
        </embed><noembed><img src = "yourimage.gif" alt = "Alternative Media"></noembed>';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new EmbedHasAssociatedNoEmbed($dom);

        $this->assertEquals(0, $rule->check(), 'Embed Has No Associated NoEmbed should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<embed type="video/webm"
        src="/media/examples/flower.mp4"
        width="250"
        height="200">';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new EmbedHasAssociatedNoEmbed($dom);

        $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have one issue.');
    }
}