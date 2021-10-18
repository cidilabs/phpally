<?php

use CidiLabs\PhpAlly\Video\Vimeo;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class VimeoTest extends PhpAllyTestCase {

    public function testCaptionsMissing()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 0,
            "data": []
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($vimeo->captionsMissing($response), 0);
    }

    public function testCaptionsMissingHasCaptions()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 2,
            "data": [{"language": "en"}, {"language": "es"}]
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($vimeo->captionsMissing($response), 2);
    }

    public function testCaptionsLanguage()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "en"}]
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($vimeo->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageFailure()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "es"}]
        }';

        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($vimeo->captionsLanguage($response), 0);
    }

    public function testCaptionsNoLanguage()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "en"}]
        }';

        $vimeo = new Vimeo($client, '', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($vimeo->captionsLanguage($response), 2);
    }

    public function testCaptionsNoLanguageFailure()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $string = '{
            "total": 1,
            "data": [{"language": "es"}]
        }';

        $vimeo = new Vimeo($client, '', 'testApikey');
        $response = new Response(200, ['Content-Type' => 'application/json'], $string);

        $this->assertEquals($vimeo->captionsLanguage($response), 0);
    }

    
}