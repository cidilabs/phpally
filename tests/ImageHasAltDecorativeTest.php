<?php

use CidiLabs\PhpAlly\Rule\ImageHasAltDecorative;

class ImageHasAltDecorativeTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" role="presentation"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt Decorative should have no issues.');
    }

    public function testCheckTrueBlankAltText()
    {
        $html = '<div><img src="invalidImage.png" role="presentation" alt=""></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt Decorative should have no issues.');
    }

    public function testCheckTrueNotDecorative()
    {
        $html = '<div><img src="invalidImage.png" role="none" alt="This should be here"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Alt Decorative should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><img src="validDecorativeImage.png" role="presentation" alt="Unnecessary"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasAltDecorative($dom);

        $this->assertEquals(1, $rule->check(), 'Image Has Alt Decorative should have one issue.');
    }
}