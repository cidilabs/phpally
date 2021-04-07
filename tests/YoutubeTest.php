<?php

use CidiLabs\PhpAlly\Youtube;
use GuzzleHttp\Client;

class YoutubeTest extends PhpAllyTestCase {

    public function testCaptionsMissingAsrTrack()
    {
        $url = 'https://www.youtube.com/watch?v=liJVSwOiiwg';
        $client = new Client();
        $youtube = new Youtube($client);

        $this->assertEquals(0, $youtube->captionsMissing($url), 'Youtube Test should return a 0 to indicate missing captions');
    }

    public function testCaptionsMissingHasCaptions()
    {
        $url = 'https://www.youtube.com/watch?v=qfJthDvcZ08';
        $client = new Client();
        $youtube = new Youtube($client);

        $this->assertEquals(2, $youtube->captionsMissing($url), 'Youtube Test should return a 2 to indicate that captions were found');
    }

    public function testCaptionsLanguageFail(){
        $url = 'https://www.youtube.com/watch?v=vFF0uV9AOB8';
        $client = new Client();
        $youtube = new Youtube($client);

        $this->assertEquals(0, $youtube->captionsLanguage($url), 'Youtube Test should return a 0 to indicate missing captions');
    }

    public function testCaptionsLanguageSuccess(){
        $url = 'https://www.youtube.com/watch?v=vFF0uV9AOB8';
        $client = new Client();
        $youtube = new Youtube($client, 'es');

        $this->assertEquals(2, $youtube->captionsLanguage($url), 'Youtube Test should return a 2 to indicate captions are correct language');
    }

}