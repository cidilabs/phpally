<?php

use CidiLabs\PhpAlly\Youtube;
use GuzzleHttp\Client;

class YoutubeTest extends PhpAllyTestCase {

    public function testCaptionsMissingAsrTrack()
    {
        $url = 'https://www.youtube.com/watch?v=liJVSwOiiwg';
        $client = new Client();
        $youtube = new Youtube($client);

        $this->assertEquals(0, $youtube->captionsMissing($url), 'Video Embed Check should have no issues.');
    }

}