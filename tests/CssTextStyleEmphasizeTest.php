<?php

use CidiLabs\PhpAlly\Rule\CssTextStyleEmphasize;

class CssTextStyleEmphasizeTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = $this->getGoodColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new CssTextStyleEmphasize($dom);

        $this->assertEquals(0, $rule->check(), 'Css Text Style Emphasize should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = $this->getColorContrastHtml();
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new CssTextStyleEmphasize($dom);

        $this->assertEquals(1, $rule->check(), 'Css Text Style Emphasize should have two issues.');
    }
}