<?php

use CidiLabs\PhpAlly\Rule\CssTextStyleEmphasize;

class CssTextStyleEmphasizeTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = $this->getGoodColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(0, $rule->check(), 'Css Text Style Emphasize should have no issues.');
    }

    public function testCheckTrueChildTag()
    {
        $html = $this->getEphasisPass();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(0, $rule->check(), 'Css Text Style Emphasize should have no issues.');
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

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(1, $rule->check(), 'Css Text Style Emphasize should have two issues.');
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

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(0, $rule->check(), 'CSS Text Style Emphasize should have no issues.');
    }

    public function testCompletelyColoredHeader()
    {
        $html = '<h2><span style="color: #008000;">This is a heading with color applied</span></h2>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(0, $rule->check(), 'CSS Text Style Emphasize should have no issues.');
    }

    public function testPartiallyColoredHeader()
    {
        $html = '<h2>This is a <span style="color: #008000;">heading</span> with only some color applied</h2>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(1, $rule->check(), 'CSS Text Style Emphasize should have one issue.');
    }

    public function testNestedDifferentColorInHeader()
    {
        $html = '<h2><span style="color: #008000;">This is a heading with <span style="color: #3366ff;">two colors</span> applied</span></h2>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45'
        ];

        $rule = new CssTextStyleEmphasize($dom, $options);

        $this->assertEquals(1, $rule->check(), 'CSS Text Style Emphasize should have one issue.');
    }

}
