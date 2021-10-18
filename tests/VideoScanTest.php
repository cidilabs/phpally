<?php

use CidiLabs\PhpAlly\Rule\VideoScan;
use CidiLabs\PhpAlly\Video\Youtube;
use CidiLabs\PhpAlly\Video\Vimeo;
use CidiLabs\PhpAlly\Video\Kaltura;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class VideosScanTest extends PhpAllyTestCase {
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
        $string = '{
            "items": []
        }';
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->setMethods(array('getCaptionData'))
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
        $string = '{
            "total": 0,
            "data": []
        }';
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->setMethods(array('getCaptionData'))
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
        $response = json_decode('{
            "objects": [],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $ruleMock = $this->getMockBuilder(VideoScan::class)
            ->setConstructorArgs([$dom, $options])
            ->setMethods(array('getCaptionData'))
            ->getMock();

        $ruleMock->expects($this->once())
            ->method('getCaptionData')
            ->will($this->returnValue($response));

        $this->assertEquals(1, $ruleMock->check());
    }

    public function testCheckNoApiKey()
    {
        $html = ['<embed type="video/webm" src="https://www.youtube.com/watch?v=1xZxxVlu7BM" width="400" height="300">', 
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
            ->getMock();

            $this->assertEquals(0, $ruleMock->check());
        }
    }
}