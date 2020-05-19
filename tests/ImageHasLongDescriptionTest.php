<?php

use CidiLabs\PhpAlly\Rule\ImageHasLongDescription;

class ImageHasLongDescriptionTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" alt="Valid Image" longdesc="Long image description"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasLongDescription($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Long Description should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><img src="img.png" alt="Long Image Description" longdesc="Long Image Description"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageHasLongDescription($dom);

        $this->assertEquals(1, $rule->check(), 'Image Has Long Description should have one issue.');
    }
}