<?php

use CidiLabs\PhpAlly\Video\Kaltura;

class KalturaTest extends PhpAllyTestCase {

    public function testCaptionsMissingSuccess()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('[
          {
            "languageCode": "en"
          }
        ]');

        $this->assertEquals($kaltura->captionsMissing($response), Kaltura::KALTURA_SUCCESS);
    }

    public function testCaptionsMissingFailure()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = [];

        $this->assertEquals($kaltura->captionsMissing($response), Kaltura::KALTURA_FAIL);
    }

    public function testCaptionsLanguageSuccess()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('[
            {
            "languageCode": "en"
            }
        ]');

        $this->assertEquals($kaltura->captionsLanguage($response), Kaltura::KALTURA_SUCCESS);
    }

    public function testCaptionsLanguageEmpty()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = [];

        $this->assertEquals($kaltura->captionsLanguage($response), Kaltura::KALTURA_SUCCESS);
    }

    public function testCaptionsLanguageWrongLanguage()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('[
            {
                "languageCode": "es"
            }
        ]');

        $this->assertEquals($kaltura->captionsLanguage($response), Kaltura::KALTURA_FAIL);
    }

    public function testCaptionsLanguageWrongLanguageInverse()
    {
        $kaltura = new Kaltura('es', 'testApiKey', 'testEmail');
        $response = json_decode('[
            {
                "languageCode": "en"
            }
        ]');

        $this->assertEquals($kaltura->captionsLanguage($response), Kaltura::KALTURA_FAIL);
    }

    public function testCaptionsNoLanguage()
    {
        $kaltura = new Kaltura('', 'testApiKey', 'testEmail');
        $response = json_decode('[
            {
                "languageCode": "en"
            }
        ]');

        $this->assertEquals($kaltura->captionsLanguage($response), Kaltura::KALTURA_SUCCESS);
    }

    public function testCaptionsNoLanguageFailure()
    {
        $kaltura = new Kaltura('', 'testApiKey', 'testEmail');
        $response = json_decode('[
            {
                "languageCode": "es"
            }
        ]');

        $this->assertEquals($kaltura->captionsLanguage($response), Kaltura::KALTURA_FAIL);
    }

}