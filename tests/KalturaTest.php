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

    public function testCaptionsLanguageFailureEmpty()
    {
        $kaltura = new Kaltura('en', 'testApiKey', 'testEmail');
        $response = json_decode('{
            "objects": [],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }');

        $this->assertEquals($kaltura->captionsLanguage($response), 2);
    }

    public function testCaptionsLanguageFailureWrongLanguage()
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

    public function testCaptionsLanguageFailureWrongLanguageInverse()
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

}