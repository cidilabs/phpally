<?php

use CidiLabs\PhpAlly\Video\Kaltura;

class KalturaTest extends PhpAllyTestCase {

    public function testCaptionsMissingSuccess()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [
              {
                "languageCode": "en"
              }
            ],
            "totalCount": 1,
            "objectType": "KalturaCaptionAssetListResponse"
          }');

        $this->assertEquals($kaltura->captionsMissing($response), 2);
    }

    public function testCaptionsMissingFailure()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsMissing($response), 0);
    }

    public function testCaptionsLanguageSuccess()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [
              {
                "languageCode": "en"
              }
            ],
            "totalCount": 1,
            "objectType": "KalturaCaptionAssetListResponse"
          }');

        $this->assertEquals($kaltura->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageEmpty()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageWrongLanguage()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [
                {
                  "languageCode": "es"
                }
              ],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsLanguage($response), 0);
    }

    public function testCaptionsLanguageWrongLanguageInverse()
    {
        $kaltura = new Kaltura('es', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [
                {
                  "languageCode": "en"
                }
              ],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsLanguage($response), 0);
    }

    public function testCaptionsNoLanguage()
    {
        $kaltura = new Kaltura('', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [
                {
                  "languageCode": "en"
                }
              ],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsLanguage($response), 2);
    }

    public function testCaptionsNoLanguageFailure()
    {
        $kaltura = new Kaltura('', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [
                {
                  "languageCode": "es"
                }
              ],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsLanguage($response), 0);
    }

}