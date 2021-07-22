<?php

use CidiLabs\PhpAlly\Rule\VideosEmbeddedOrLinkedNeedCaptions;

class VideosEmbeddedOrLinkedNeedCaptionsTest extends PhpAllyTestCase {

    public function testCheckTwoIssues()
    {
        $html = '<a href="https://vimeo.com/205755088"></a>
                 <embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];

        $ruleMock = $this->getMockBuilder(VideosEmbeddedOrLinkedNeedCaptions::class)
            ->setConstructorArgs([$dom, $options])
            ->setMethods(array('getCaptionState'))
            ->getMock();

        $ruleMock->expects($this->exactly(2))
            ->method('getCaptionState')
            ->will($this->returnValue(0));

        $this->assertEquals(2, $ruleMock->check());
    }

    public function testCaptionsMissingHasCaptions()
    {
        $html = '<a href="https://vimeo.com/83595709"></a>
                 <embed type="video/webm" src="https://www.youtube.com/watch?v=qfJthDvcZ08" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];

        $ruleMock = $this->getMockBuilder(VideosEmbeddedOrLinkedNeedCaptions::class)
            ->setConstructorArgs([$dom, $options])
            ->setMethods(array('getCaptionState'))
            ->getMock();

        $ruleMock->expects($this->exactly(2))
            ->method('getCaptionState')
            ->will($this->returnValue(2));

        $this->assertEquals(0, $ruleMock->check());
    }
}