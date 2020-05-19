<?php

use CidiLabs\PhpAlly\Rule\ImageAltIsTooLong;

class ImageAltIsTooLongTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><img src="validImage.png" alt="Valid Image"></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltIsTooLong($dom);

        $this->assertEquals(0, $rule->check(), 'Image Alt Is Different should have no issues.');
    }

    public function testCheckFalseTooLong()
    {
        $html = '<div><img src="validImage.png" alt="This is way too long to be alt text. The purpose of alt text is to describe images to visitors who are unable to see them and therefore this much description is most likely not necessary."></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ImageAltIsTooLong($dom);

        $this->assertEquals(1, $rule->check(), 'Image Alt Is Different should have no issues.');
    }
}