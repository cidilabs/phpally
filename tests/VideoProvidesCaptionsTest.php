<?php

use CidiLabs\PhpAlly\Rule\VideoProvidesCaptions;

class VideoProvidesCaptionsTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = $this->getVideoTagHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoProvidesCaptions($dom);

        $this->assertEquals(0, $rule->check(), 'Video Embed Check should have no issues.');
    }

    public function testCheckFalseIframe()
    {
        $html = $this->getBadVideoTagHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoProvidesCaptions($dom);

        $this->assertEquals(1, $rule->check(), 'Video Embed Check should have one issue.');
    }
}