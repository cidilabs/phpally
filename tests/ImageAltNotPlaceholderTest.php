<?php

use CidiLabs\PhpAlly\Rule\ImageAltNotPlaceholder;

class ImageAltNotPlaceholderTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" alt="Valid Image"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotPlaceholder($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Is Different should have no issues.');
    }

    public function testCheckTrueNoAlt()
    {
        $html = '<div><img src="validImage.png" alt=""></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotPlaceholder($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Is Different should have no issues.');
    }

    public function testCheckFalseRegExMatch()
    {
        $html = '<div><img src="validImage.png" alt="98k bytes"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotPlaceholder($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Is Different should have one issue.');
    }

    public function testCheckFalsePlaceHolderText()
    {
        $html = '<div><img src="validImage.png" alt="nbsp"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotPlaceholder($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Is Different should have one issue.');
    }

    public function testCheckFalsePlaceHolderTextOtherLanguage()
    {
        $html = '<div><img src="validImage.png" alt="espacio"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltNotPlaceholder($dom);
        $rule->setLanguage('es');

        $this->assertEquals(1, $rule->check(), 'Image Alt Is Different should have one issue.');
    }
}