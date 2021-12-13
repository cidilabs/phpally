<?php

use CidiLabs\PhpAlly\Rule\IframeNotHandled;

class IframeNotHandledTest extends PhpAllyTestCase {
    public function testCheckEmpty()
    {
        $html = '<div></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new IframeNotHandled($dom);

        $this->assertEquals(0, $rule->check(), 'IframeNotHandled should have no issues.');
    }

    public function testCheckTrueIframe()
    {
        $html = '<div><iframe src="https://www.thisisatest.com/"></iframe></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new IframeNotHandled($dom);

        $this->assertEquals(1, $rule->check(), 'IframeNotHandled should have one issue.');
    }

    public function testCheckFalseIframe()
    {
        $html = '<div>
                    <iframe src="https://www.dailymotion.com/us"></iframe>
                    <iframe src="https://www.youtube.com/watch?v=1xZxxVlu7BM"></iframe>
                    <iframe src="https://vimeo.com/205755088"></iframe>
                    <iframe src="https://cdnapisec.kaltura.com/p/4183983"></iframe>
                </div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new IframeNotHandled($dom);

        $this->assertEquals(0, $rule->check(), 'IframeNotHandled should have no issues.');
    }
}
