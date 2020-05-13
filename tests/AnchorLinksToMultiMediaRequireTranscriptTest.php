<?php

use CidiLabs\PhpAlly\Rule\AnchorLinksToMultiMediaRequireTranscript;

class AnchorLinksToMultiMediaRequireTranscriptTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p><a href="https://cnn.com">Valid Link</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorLinksToMultiMediaRequireTranscript($dom);

        $this->assertEquals(0, $rule->check(), 'Anchor Links To Multimedia Require Transcript should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><p><a href="failCase.mov"></a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorLinksToMultiMediaRequireTranscript($dom);

        $this->assertEquals(1, $rule->check(), 'Anchor Links To Multimedia Require Transcript should have one issue.');
    }
}