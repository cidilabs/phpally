<?php

use CidiLabs\PhpAlly\Youtube;
use GuzzleHttp\Client;

class YoutubeTest extends PhpAllyTestCase {

    public function testCaptionsMissingAsrTrack()
    {
        $url = 'https://www.youtube.com/watch?v=1xZxxVlu7BM';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'youtubeApiKey' => 'AIzaSyB5bTf8rbYwiM73k1rj8dDnwEalwTqdz_c'
        ];
        $youtube = new Youtube($client, 'en', $options['youtubeApiKey']);

        $this->assertEquals(0, $youtube->captionsMissing($url), 'Youtube Test should return a 0 to indicate missing captions');
    }

    public function testCaptionsMissingHasCaptions()
    {
        $url = 'https://www.youtube.com/watch?v=qfJthDvcZ08';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'youtubeApiKey' => 'AIzaSyB5bTf8rbYwiM73k1rj8dDnwEalwTqdz_c'
        ];
        $youtube = new Youtube($client, 'en', $options['youtubeApiKey']);

        $this->assertEquals(2, $youtube->captionsMissing($url), 'Youtube Test should return a 2 to indicate that captions were found');
    }

    public function testCaptionsLanguageFail(){
        $url = 'https://www.youtube.com/watch?v=vFF0uV9AOB8';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'youtubeApiKey' => 'AIzaSyB5bTf8rbYwiM73k1rj8dDnwEalwTqdz_c'
        ];
        $youtube = new Youtube($client, 'en', $options['youtubeApiKey']);

        $this->assertEquals(0, $youtube->captionsLanguage($url), 'Youtube Test should return a 0 to indicate missing captions');
    }

    public function testCaptionsLanguageSuccess(){
        $url = 'https://www.youtube.com/watch?v=vFF0uV9AOB8';
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $options = [
            'youtubeApiKey' => 'AIzaSyB5bTf8rbYwiM73k1rj8dDnwEalwTqdz_c'
        ];
        $youtube = new Youtube($client, 'es', $options['youtubeApiKey']);

        $this->assertEquals(2, $youtube->captionsLanguage($url), 'Youtube Test should return a 2 to indicate captions are correct language');
    }

}