<?php

use CidiLabs\PhpAlly\Rule\VideosEmbeddedOrLinkedNeedCaptions;

class VideosEmbeddedOrLinkedNeedCaptionsTest extends PhpAllyTestCase {

    public function testCheckTwoIssues()
    {
        $html = '<a href="https://vimeo.com/205755088"></a>
                 <embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideosEmbeddedOrLinkedNeedCaptions($dom);

        $this->assertEquals(2, $rule->check(), 'Youtube Test will pass with auto-generated captions, Vimeo should fail.');
    }

    public function testCaptionsMissingHasCaptions()
    {
        $html = '<a href="https://vimeo.com/83595709"></a>
                 <embed type="video/webm" src="https://www.youtube.com/watch?v=qfJthDvcZ08" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideosEmbeddedOrLinkedNeedCaptions($dom);

        $this->assertEquals(0, $rule->check(), 'Youtube Test should return a 0 to indicate missing captions');
    }
}