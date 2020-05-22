<?php

use CidiLabs\PhpAlly\Rule\ImageHasAlt;

class ImageHasAltTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" alt="Valid Image"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAlt($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt should have no issues.');
    }

    public function testCheckTrueDecorative()
    {
        $html = '<div><img src="validDecorativeImage.png" data-decorative="true"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAlt($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt should have no issues.');
    }

    public function testCheckFalseNoAltText()
    {
        $html = '<div><img src="invalidImage.png"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAlt($dom);

        $this->assertEquals(1, $rule->check(), 'Image Has Alt should have one issue.');
    }

    public function testCheckDataDecorativeFalse()
    {
        $html = '<div><img src="validDecorativeImage.png" data-decorative="false"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAlt($dom);

        $this->assertEquals(1, $rule->check(), 'Image Has Alt should have one issue.');
    }
}