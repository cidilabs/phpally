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

    public function testCheckBackgroundAttributeColorNamePass() 
    {
        $html = $this->getGoodBackgroundContrastColorNameHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check(), 'CSS Text Has Contrast should have no issues.');
    }

    public function testCheckBackgroundAttributeColorNameFail() 
    {
        $html = $this->getBadBackgroundContrastColorNameHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(1, $rule->check(), 'CSS Text Has Contrast should have no issues.');
    }

    public function testCheckBackgroundAttributeRgbPass() 
    {
        $html = $this->getGoodBackgroundContrastRgbHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check(), 'CSS Text Has Contrast should have no issues.');
    }

    public function testCheckBackgroundAttributeRgbFail() 
    {
        $html = $this->getBadBackgroundContrastRgbHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];
        
        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(1, $rule->check(), 'CSS Text Has Contrast should have no issues.');
    }

    public function testCheckCustomVar()
    {
        $html = $this->getBackgroundVarHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check(), 'Css Text Has Contrast should have no issues.');
    }

    public function testCheckDesignPlusClassnames()
    {
        $html = $this->getDesignPlusHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check());
    }

    public function testConflictingAttributes()
    {
        $html = '<h3 style="background: #58595B; text-align: left; padding-left: 5px;"><img style="padding: 5px;" role="presentation" src="https://utk.test.instructure.com/courses/147193/files/11821925/download" alt="" width="40" height="40" align="absmiddle" data-decorative="true" data-api-endpoint="https://utk.test.instructure.com/api/v1/courses/147193/files/11821925" data-api-returntype="File" /><span style="color: #ffffff;"><strong>Basic Elements of the Course</strong></span></h3>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextHasContrast($dom, $options);

        $this->assertEquals(0, $rule->check());
    }
}