<?php

use CidiLabs\PhpAlly\Rule\AnchorMustContainText;

class AnchorLinksToSoundFilesNeedTranscriptsTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p><a href="https://cnn.com">Valid Link</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorMustContainText($dom);

        $this->assertEquals(0, $rule->check(), 'Anchor Must Contain Text has no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><p><a href="https://cnn.com"></a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorMustContainText($dom);

        $this->assertEquals(1, $rule->check(), 'Anchor Must Contain Text has one issue.');
    }
}