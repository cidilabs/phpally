<?php

use CidiLabs\PhpAlly\Video\Youtube;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class YoutubeTest extends PhpAllyTestCase {

    private $link_url = 'https://www.youtube.com/watch?v=1xZxxVlu7BM';

    public function testCaptionsMissing()
    {
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": []
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsMissing($response), 0);
    }

    public function testCaptionsMissingHasCaptions()
    {
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "asr",
                        "language": "es"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsMissing($response), 2);
    }

    public function testCaptionsLanguageFail(){
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsLanguage($response), 0);
    }

    public function testCaptionsLanguageSuccess(){
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "en"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageEmpty(){
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": []
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsLanguage($response), 2);
    }

    public function testCaptionsNoLanguage(){
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "en"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, '', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsLanguage($response), 2);
    }

    public function testCaptionsAutoGeneratedFailure(){
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "asr",
                        "language": "en"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsAutoGenerated($response), 0);
    }

    public function testCaptionsAutoGeneratedSuccess(){
        // $link_url = $this->link_url;
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "items": [
                {
                    "snippet": {
                        "trackKind": "asr",
                        "language": "ru"
                    }
                },
                {
                    "snippet": {
                        "trackKind": "standard",
                        "language": "es-419"
                    }
                }
            ]
        }';

        $youtube = new Youtube($client, 'en', 'testApiKey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        // $youtubeMock = $this->getMockBuilder(Youtube::class)
        //      ->setConstructorArgs([$client, 'en', 'testApiKey'])
        //      ->onlyMethods(array('getVideoData'))
        //      ->getMock(); 

        // $youtubeMock->expects($this->once())
        //     ->method('getVideoData')
        //     ->will($this->returnValue($response));

        $this->assertEquals($youtube->captionsAutoGenerated($response), 2);
    }

}