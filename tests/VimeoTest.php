<?php

use CidiLabs\PhpAlly\Video\Vimeo;

class VimeoTest extends PhpAllyTestCase {

    public function testCaptionsMissing()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = [];
        
        $this->assertEquals($vimeo->captionsMissing($response), Vimeo::VIMEO_FAIL);
    }

    public function testCaptionsMissingHasCaptions()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = [
            (object) ["language" => "en"],
            (object) ["language" => "es"]
        ];
        
        $this->assertEquals($vimeo->captionsMissing($response), Vimeo::VIMEO_SUCCESS);
    }

    public function testCaptionsLanguage()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = [(object) ["language" => "en"]];

        $this->assertEquals($vimeo->captionsLanguage($response), Vimeo::VIMEO_SUCCESS);
    }

    public function testCaptionsLanguageFailure()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $vimeo = new Vimeo($client, 'en', 'testApikey');
        $response = [(object) ["language" => "es"]];

        $this->assertEquals($vimeo->captionsLanguage($response), Vimeo::VIMEO_FAIL);
    }

    public function testCaptionsNoLanguage()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $vimeo = new Vimeo($client, '', 'testApikey');
        $response = [(object) ['language' => 'en']];

        $this->assertEquals($vimeo->captionsLanguage($response), Vimeo::VIMEO_SUCCESS);
    }

    public function testCaptionsNoLanguageFailure()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $vimeo = new Vimeo($client, '', 'testApikey');
        $response = [(object) ['language' => 'es']];

        $this->assertEquals($vimeo->captionsLanguage($response), 0);
    }

    
}