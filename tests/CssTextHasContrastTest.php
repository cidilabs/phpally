<?php

use CidiLabs\PhpAlly\Rule\CssTextHasContrast;

class CssTextHasContrastTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = $this->getGoodColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new CssTextHasContrast($dom);

        $this->assertEquals(0, $rule->check(), 'CSS Text Has Contrast should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = $this->getColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new CssTextHasContrast($dom);

        $this->assertEquals(1, $rule->check(), 'CSS Text Has Contrast should have one issue.');
    }

    public function testCheckTrueRGB() 
    {
        $html = $this->getGoodColorContrastRGBHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new CssTextHasContrast($dom);

        $this->assertEquals(0, $rule->check(), 'CSS Text Has Contrast should have one issue.');
    }
}