<?php

use CidiLabs\PhpAlly\Kaltura;

class KalturaTest extends PhpAllyTestCase {

    private $test_url = 'https://cdnapisec.kaltura.com/p/4183983/sp/418398300/embedIframeJs/uiconf_id/48252953/partner_id/4183983?iframeembed=true&playerId=kaltura_player_1626379517&entry_id=1_qgxxsknz" width="400" height="333';

    public function testCaptionsMissingIvalidURL()
    {
        $link_url = 'fakeUrl';
        $result = false;

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
             ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
             ->onlyMethods(array('getVideoData'))
             ->getMock(); 

        $this->assertEquals($kalturaMock->captionsMissing($link_url), 2);
    }

    public function testCaptionsMissingSuccess()
    {
        $link_url = $this->test_url;
        $json = '{
            "objects": [
              {
                "languageCode": "en"
              }
            ],
            "totalCount": 1,
            "objectType": "KalturaCaptionAssetListResponse"
          }';

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
            ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
            ->onlyMethods(array('getVideoData'))
            ->getMock();

        $kalturaMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue(json_decode($json)));

        $this->assertEquals($kalturaMock->captionsMissing($link_url), 2);
    }

    public function testCaptionsMissingFailure()
    {
        $link_url = $this->test_url;
        $json = '{
            "objects": [],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }';

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
            ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
            ->onlyMethods(array('getVideoData'))
            ->getMock();

        $kalturaMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue(json_decode($json)));

        $this->assertEquals($kalturaMock->captionsMissing($link_url), 0);
    }

    public function testCaptionsLanguageInvalidURL()
    {
        $link_url = 'fakeUrl';
        $result = false;
        
        $kalturaMock = $this->getMockBuilder(Kaltura::class)
             ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
             ->onlyMethods(array('getVideoData'))
             ->getMock(); 

        $this->assertEquals($kalturaMock->captionsLanguage($link_url), 2);
    }

    public function testCaptionsLanguageSuccess()
    {
        $link_url = $this->test_url;
        $json = '{
            "objects": [
              {
                "languageCode": "en"
              }
            ],
            "totalCount": 1,
            "objectType": "KalturaCaptionAssetListResponse"
          }';

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
            ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
            ->onlyMethods(array('getVideoData'))
            ->getMock();

        $kalturaMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue(json_decode($json)));

        $this->assertEquals($kalturaMock->captionsLanguage($link_url), 2);
    }

    public function testCaptionsLanguageFailureEmpty()
    {
        $link_url = $this->test_url;
        $json = '{
            "objects": [],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }';

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
            ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
            ->onlyMethods(array('getVideoData'))
            ->getMock();

        $kalturaMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue(json_decode($json)));

        $this->assertEquals($kalturaMock->captionsLanguage($link_url), 0);
    }

    public function testCaptionsLanguageFailureWrongLanguage()
    {
        $link_url = $this->test_url;
        $json = '{
            "objects": [
                {
                  "languageCode": "es"
                }
              ],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }';

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
            ->setConstructorArgs(['en', 'testApiKey', 'testEmail'])
            ->onlyMethods(array('getVideoData'))
            ->getMock();

        $kalturaMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue(json_decode($json)));

        $this->assertEquals($kalturaMock->captionsLanguage($link_url), 0);
    }

    public function testCaptionsLanguageFailureWrongLanguageInverse()
    {
        $link_url = $this->test_url;
        $json = '{
            "objects": [
                {
                  "languageCode": "en"
                }
              ],
            "totalCount": 0,
            "objectType": "KalturaCaptionAssetListResponse"
        }';

        $kalturaMock = $this->getMockBuilder(Kaltura::class)
            ->setConstructorArgs(['es', 'testApiKey', 'testEmail'])
            ->onlyMethods(array('getVideoData'))
            ->getMock();

        $kalturaMock->expects($this->once())
            ->method('getVideoData')
            ->will($this->returnValue(json_decode($json)));

        $this->assertEquals($kalturaMock->captionsLanguage($link_url), 0);
    }

}