<?php

use CidiLabs\PhpAlly\Vimeo;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class VimeoTest extends PhpAllyTestCase {

    private $link_url = 'https://vimeo.com/205755088';

    public function testCaptionsMissing()
    {
        $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 0,
            "data": []
        }';
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $vimeoMock = $this->getMockBuilder(Vimeo::class)
             ->setConstructorArgs([$client, 'en', 'testApiKey'])
             ->setMethods(array('getVideoData'))
             ->getMock(); 

        $vimeoMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue($response));

        $this->assertEquals($vimeoMock->captionsMissing($link_url), 0);
    }

    public function testCaptionsMissingHasCaptions()
    {
        $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 2,
            "data": [{"language": "en"}, {"language": "es"}]
        }';
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $vimeoMock = $this->getMockBuilder(Vimeo::class)
             ->setConstructorArgs([$client, 'en', 'testApiKey'])
             ->setMethods(array('getVideoData'))
             ->getMock(); 

        $vimeoMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue($response));

        $this->assertEquals($vimeoMock->captionsMissing($link_url), 2);
    }

    public function testCaptionsLanguage()
    {
        $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "en"}]
        }';
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $vimeoMock = $this->getMockBuilder(Vimeo::class)
             ->setConstructorArgs([$client, 'en', 'testApiKey'])
             ->setMethods(array('getVideoData'))
             ->getMock(); 

        $vimeoMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue($response));

        $this->assertEquals($vimeoMock->captionsLanguage($link_url), 2);
    }

    public function testCaptionsLanguageFailure()
    {
        $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "es"}]
        }';
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $vimeoMock = $this->getMockBuilder(Vimeo::class)
             ->setConstructorArgs([$client, 'en', 'testApiKey'])
             ->setMethods(array('getVideoData'))
             ->getMock(); 

        $vimeoMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue($response));

        $this->assertEquals($vimeoMock->captionsLanguage($link_url), 0);
    }

    
}