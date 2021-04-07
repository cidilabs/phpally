<?php

use CidiLabs\PhpAlly\Rule\ImageAltIsDifferent;

class ImageAltIsDifferentTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" alt="Valid Image"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltIsDifferent($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Is Different should have no issues.');
    }

    public function testCheckTrueSameNameNoExtension()
    {
        $html = '<div><img src="validImage.png" alt="validImage"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltIsDifferent($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Is Different should have no issues.');
    }

    public function testCheckFalseSameNameWithExtension()
    {
        $html = '<div><img src="validImage.png" alt="validImage.png"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltIsDifferent($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Is Different should have one issue.');
    }

    public function testCheckFalseAltHasFilenameExtension()
    {
        $html = '<div><img src="validImage.png" alt="anotherImage.png"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltIsDifferent($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Is Different should have one issue.');
    }
}