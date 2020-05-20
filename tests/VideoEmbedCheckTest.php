<?php

use CidiLabs\PhpAlly\Rule\VideoEmbedCheck;

class VideoEmbedCheckTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p><a href="https://cnn.com">Valid Link</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoEmbedCheck($dom);

        $this->assertEquals(0, $rule->check(), 'Video Embed Check should have no issues.');
    }

    public function testCheckFalseIframe()
    {
        $html = '<div><iframe src="https://www.dailymotion.com/us"></iframe></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoEmbedCheck($dom);

        $this->assertEquals(1, $rule->check(), 'Video Embed Check should have one issue.');
    }

    public function testCheckFalseAnchorTag()
    {
        $html = '<div><a href="https://www.dailymotion.com/us"></a></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoEmbedCheck($dom);

        $this->assertEquals(1, $rule->check(), 'Video Embed Check should have one issue.');
    }

    public function testCheckFalseObject()
    {
        $html = '<div><object data="https://www.dailymotion.com/us" width="300" height="200"></object></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoEmbedCheck($dom);

        $this->assertEquals(1, $rule->check(), 'Video Embed Check should have one issue.');
    }
}