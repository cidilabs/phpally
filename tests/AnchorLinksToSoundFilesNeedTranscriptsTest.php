<?php

use CidiLabs\PhpAlly\Rule\AnchorLinksToSoundFilesNeedTranscripts;

class AnchorLinksToSoundFilesNeedTranscriptsTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p><a href="https://cnn.com">Valid Link</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorLinksToSoundFilesNeedTranscripts($dom);

        $this->assertEquals(0, $rule->check(), 'Anchor Links To Sound Files Links Transcript should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><p><a href="failCase.wav"></a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorLinksToSoundFilesNeedTranscripts($dom);

        $this->assertEquals(1, $rule->check(), 'Anchor Links To Sound Files Links Transcript should have one issue.');
    }
}