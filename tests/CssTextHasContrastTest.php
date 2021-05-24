<?php

use CidiLabs\PhpAlly\Rule\CssTextHasContrast;

class CssTextHasContrastTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = $this->getGoodColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check(), 'CSS Text Has Contrast should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = $this->getColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(2, $rule->check(), 'CSS Text Has Contrast should have two issues.');
    }

    public function testCheckTrueRGB() 
    {
        $html = $this->getGoodColorContrastRGBHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check(), 'CSS Text Has Contrast should have one issue.');
    }

    public function testCheckFalseWalkUpTree() 
    {
        $html = $this->getScopedColors();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(6, $rule->check(), 'CSS Text Has Contrast should have four issues.');
    }
}