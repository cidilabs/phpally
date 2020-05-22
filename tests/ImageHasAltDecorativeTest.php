<?php

use CidiLabs\PhpAlly\Rule\ImageHasAltDecorative;

class ImageHasAltDecorativeTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" data-decorative="true"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt Decorative should have no issues.');
    }

    public function testCheckTrueBlankAltText()
    {
        $html = '<div><img src="invalidImage.png" data-decorative="true" alt=""></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt Decorative should have no issues.');
    }

    public function testCheckTrueNotDecorative()
    {
        $html = '<div><img src="invalidImage.png" data-decorative="false" alt="This should be here"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt Decorative should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><img src="validDecorativeImage.png" data-decorative="true" alt="Unnecessary"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(1, $rule->check(), 'Image Has Alt Decorative should have one issue.');
    }
}