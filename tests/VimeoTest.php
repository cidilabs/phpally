<?php

use CidiLabs\PhpAlly\Video\Vimeo;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class VimeoTest extends PhpAllyTestCase {

    private $link_url = 'https://vimeo.com/205755088';

    public function testCaptionsMissing()
    {
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 0,
            "data": []
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $vimeoMock = $this->getMockBuilder(Vimeo::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $vimeoMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($vimeo->captionsMissing($response), 0);
    }

    public function testCaptionsMissingHasCaptions()
    {
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 2,
            "data": [{"language": "en"}, {"language": "es"}]
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $vimeoMock = $this->getMockBuilder(Vimeo::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $vimeoMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($vimeo->captionsMissing($response), 2);
    }

    public function testCaptionsLanguage()
    {
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "en"}]
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $vimeoMock = $this->getMockBuilder(Vimeo::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $vimeoMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($vimeo->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageFailure()
    {
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "es"}]
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $vimeoMock = $this->getMockBuilder(Vimeo::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $vimeoMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($vimeo->captionsLanguage($response), 0);
    }

    
}