<?php

use CidiLabs\PhpAlly\Vimeo;
use GuzzleHttp\Client;

class VimeoTest extends PhpAllyTestCase {

    public function testCaptionsMissing()
    {
        $url = 'https://vimeo.com/205755088';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'vimeoApiKey' => 'bef37736cfb26b6dc52986d8f531d0ad'
        ];
        $vimeo = new Vimeo($client, 'en', $options['vimeoApiKey']);

        $this->assertEquals(0, $vimeo->captionsMissing($url), 'Vimeo Test should return a 0 to indicate missing captions');
    }

    public function testCaptionsMissingHasCaptions()
    {
        $url = 'https://vimeo.com/83595709';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'vimeoApiKey' => 'bef37736cfb26b6dc52986d8f531d0ad'
        ];
        $vimeo = new Vimeo($client, 'en', $options['vimeoApiKey']);

        $this->assertEquals(2, $vimeo->captionsMissing($url), 'Vimeo Test should return a 2 to indicate that the video has captions');
    }

    public function testCaptionsLanguage()
    {
        $url = 'https://vimeo.com/83595709';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'vimeoApiKey' => 'bef37736cfb26b6dc52986d8f531d0ad'
        ];
        $vimeo = new Vimeo($client, 'en', $options['vimeoApiKey']);

        $this->assertEquals(2, $vimeo->captionsLanguage($url), 'Vimeo Test should return a 2 to indicate that the video has captions in the correct language');
    }

    public function testCaptionsLanguageFailure()
    {
        $url = 'https://vimeo.com/83595709';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'vimeoApiKey' => 'bef37736cfb26b6dc52986d8f531d0ad'
        ];
        $vimeo = new Vimeo($client, 'es', $options['vimeoApiKey']);

        $this->assertEquals(0, $vimeo->captionsLanguage($url), 'Vimeo Test should return a 0 to indicate that the video has captions in the correct language');
    }

    
}