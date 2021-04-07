<?php

use CidiLabs\PhpAlly\Rule\ImageAltNotEmptyInAnchor;

class ImageAltNotEmptyInAnchorTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<a><img src="validImage.png" alt="Valid Image"></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotEmptyInAnchor($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Not Empty should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<a><img src="img.png" alt=""></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotEmptyInAnchor($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Not Empty should have one issue.');
    }

    public function testCheckFalseSpace()
    {
        $html = '<a><img src="img.png" alt="  "></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotEmptyInAnchor($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Not Empty should have one issue.');
    }
}