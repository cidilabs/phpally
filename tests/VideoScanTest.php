<?php

use CidiLabs\PhpAlly\Rule\VideoScan;
use CidiLabs\PhpAlly\Video\Youtube;
use CidiLabs\PhpAlly\Video\Vimeo;
use CidiLabs\PhpAlly\Video\Kaltura;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class VideoScanTest extends PhpAllyTestCase {
    public function testCheckEmptyYoutube()
    {
        $html = '<embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = [];

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(1, $ruleMock->check());
    }

    public function testCheckEmptyVimeo()
    {
        $html = '<embed type="video/webm" src="https://vimeo.com/205755088" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = [];

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(1, $ruleMock->check());
    }

    public function testCheckEmptyKaltura()
    {
        $html = '<embed type="video/webm" src="https://cdnapisec.kaltura.com/p/4183983" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = [];

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(1, $ruleMock->check());
    }

    public function testCheckNoApiKey()
    {
        $html = ['<div><embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300"></div>', 
        '<embed type="video/webm" src="https://vimeo.com/205755088" width="400" height="300">', '<div><a href="https://cdnapisec.kaltura.com/p/4183983">Valid Link</a></div>'];
        $options = [
            'vimeoApiKey' => '',
            'youtubeApiKey' => '',
            'kalturaApiKey' => '',
            'kalturaUsername' => ''
        ];
        foreach ($html as $video) {
            $dom = new \DOMDocument('1.0', 'utf-8');
            $dom->loadHTML($video);

            $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods([])
            ->getMock();

            $this->assertEquals(0, $ruleMock->check());
            $this->assertCount(1, $ruleMock->getErrors());
        }
    }

    public function testCheckInvalidYoutube()
    {
        $html = '<embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = VideoScan::FAILED_CONNECTION;

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(0, $ruleMock->check(), 'No issues when API connection fails.');
        $this->assertCount(1, $ruleMock->getErrors(), 'One error found when API connection fails.');
    }

    public function testCheckInvalidVimeo()
    {
        $html = '<embed type="video/webm" src="https://vimeo.com/205755088" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = VideoScan::FAILED_CONNECTION;

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(0, $ruleMock->check(), 'No issues when API connection fails.');
        $this->assertCount(1, $ruleMock->getErrors(), 'One error found when API connection fails.');
    }

    public function testCheckInvalidKaltura()
    {
        $html = '<embed type="video/webm" src="https://cdnapisec.kaltura.com/p/4183983" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = VideoScan::FAILED_CONNECTION;

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(0, $ruleMock->check(), 'No issues when API connection fails.');
        $this->assertCount(1, $ruleMock->getErrors(), 'One error found when API connection fails.');
    }

    public function testCheckNoApiCreditsYoutube()
    {
        $html = '<embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300">';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'vimeoApiKey' => 'test',
            'youtubeApiKey' => 'test',
            'kalturaApiKey' => 'test',
            'kalturaUsername' => 'test'
        ];
        $response = VideoScan::NO_API_CREDITS;

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->onlyMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(0, $ruleMock->check(), 'No issues when credits run out.');
        $this->assertCount(1, $ruleMock->getErrors(), 'One error found when credits run out.');
    }
}