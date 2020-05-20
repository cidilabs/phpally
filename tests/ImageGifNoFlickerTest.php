<?php

use CidiLabs\PhpAlly\Rule\ImageGifNoFlicker;
//TODO: Finish these tests
class ImageGifNoFlickerTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<a><img src="validImage.png" alt="Valid Image"></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageGifNoFlicker($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Not Empty should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<a><img src="img.png" alt=""></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageGifNoFlicker($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Not Empty should have one issue.');
    }
}