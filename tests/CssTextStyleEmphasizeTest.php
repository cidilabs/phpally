<?php

use CidiLabs\PhpAlly\Rule\CssTextStyleEmphasize;

class CssTextStyleEmphasizeTest extends PhpAllyTestCase {

    public function testValidHtml()
    {
        foreach ($this->getValidTestHtml() as $key => $html) {
            foreach (CssTextStyleEmphasize::$blockElements as $blockTag) {
                foreach (CssTextStyleEmphasize::$genericTextElements as $genericTag) {
                    foreach (CssTextStyleEmphasize::$emphasizedTextElements as $emphasisTag) {
                        $search = ['{block_tag}', '{generic_tag}', '{emphasis_tag}'];
                        $replace = [$blockTag, $genericTag, $emphasisTag];

                        $testKey = str_replace($search, $replace, $key);
                        $testHtml = str_replace($search, $replace, $html);

                        $dom = new \DOMDocument('1.0', 'utf-8');
                        $dom->loadHTML($testHtml);
                        $rule = new CssTextStyleEmphasize($dom, []);

                        $this->assertEquals(0, $rule->check(), "CSS text style emphasis: {$testKey}");
                    }
                }
            }
        }
    }

    public function testInvalidHtml()
    {
        foreach ($this->getInvalidTestHtml() as $key => $html) {
            foreach (CssTextStyleEmphasize::$blockElements as $blockTag) {
                foreach (CssTextStyleEmphasize::$genericTextElements as $genericTag) {
                    foreach (CssTextStyleEmphasize::$emphasizedTextElements as $emphasisTag) {
                        $search = ['{block_tag}', '{generic_tag}', '{emphasis_tag}'];
                        $replace = [$blockTag, $genericTag, $emphasisTag];
                        
                        $testKey = str_replace($search, $replace, $key);
                        $testHtml = str_replace($search, $replace, $html);

                        $dom = new \DOMDocument('1.0', 'utf-8');
                        $dom->loadHTML($testHtml);
                        $rule = new CssTextStyleEmphasize($dom, []);

                        $this->assertEquals(1, $rule->check(), "CSS text style emphasis: {$testKey}");
                    }
                }
            }
        }
    }

    protected function getValidTestHtml()
    {
        return [
            // block tag outside generic, no text
            "valid {block_tag}, colored {generic_tag}, no text" => "<{block_tag}><{generic_tag} style='color: red'>COLORED EMPHASIS</{generic_tag}></{block_tag}>",
            "valid {block_tag}, bgcolor {generic_tag}, no text" => "<{block_tag}><{generic_tag} style='background-color: red;'>BG COLORED EMPHASIS</{generic_tag}></{block_tag}>",
            
            // block tag outside generic w/ font-weight
            "valid {block_tag} > colored {generic_tag} with font-weight" => "<{block_tag}><{generic_tag} style='color: #FF0000; font-weight: bold;'>COLORED EMPHASIS</{generic_tag}>.</{block_tag}>",
            "valid {block_tag} > bgcolor {generic_tag} with font-weight" => "<{block_tag}><{generic_tag} style='background-color: #FF0000; font-weight: bold'>BG COLORED EMPHASIS</{generic_tag}>.</{block_tag}>",

            // block tag outside generic w/ font-style
            "valid {block_tag} > colored {generic_tag} with font-style" => "<{block_tag}><{generic_tag} style='color: #F00; font-style: italic;'>COLORED EMPHASIS</{generic_tag}>.</{block_tag}>",
            "valid {block_tag} > bgcolor {generic_tag} with font-style" => "<{block_tag}><{generic_tag} style='background-color: #F00; font-style: italic;'>BG COLORED EMPHASIS</{generic_tag}>.</{block_tag}>",

            // emphasis tag outside generic
            "valid {emphasis_tag} > colored {generic_tag}" => "<{emphasis_tag}><{generic_tag} style='color: rgb(255,0,0);'>COLORED EMPHASIS</{generic_tag}></{emphasis_tag}>",
            "valid {emphasis_tag} > bgcolor {generic_tag}" => "<{emphasis_tag}><{generic_tag} style='background-color: rgb(255,0,0);'>BG COLORED EMPHASIS</{generic_tag}></{emphasis_tag}>",

            // emphasis tag inside generic, no text
            "valid colored {generic_tag} > {emphasis_tag}" => "<{generic_tag} style='color: rgba(255,0,0,1);'><{emphasis_tag}>COLORED EMPHASIS</{emphasis_tag}></{generic_tag}>",
            "valid bgcolor {generic_tag} > {emphasis_tag}" => "<{generic_tag} style='background-color: rgba(255,0,0,1);'><{emphasis_tag}>BG COLORED EMPHASIS</{emphasis_tag}></{generic_tag}>",
            
            // emphasis tag w/ color
            "valid colored {emphasis_tag}" => "<{block_tag}><{emphasis_tag} style='color: red'>COLORED EMPHASIS</{emphasis_tag}>.</{block_tag}>",
            "valid bgcolor {emphasis_tag}" => "<{block_tag}><{emphasis_tag} style='background-color: red;'>BG COLORED EMPHASIS</{emphasis_tag}>.</{block_tag}>",

            // &nbsp;
            "valid {block_tag}, bgcolor {generic_tag}" => "<{block_tag}><{generic_tag} style='background-color: red;'>&nbsp;&nbsp;&nbsp;</{generic_tag}></{block_tag}>",
        ];
    }

    protected function getInvalidTestHtml()
    {
        return [
            "invalid {block_tag}, colored {generic_tag}, text before" => "<{block_tag}>Example text with <{generic_tag} style='color: red'>COLORED EMPHASIS</{generic_tag}>.</{block_tag}>",
            "invalid {block_tag}, bgcolor {generic_tag}, text before" => "<{block_tag}>Example text with <{generic_tag} style='background-color: red;'>BG COLORED EMPHASIS</{generic_tag}>.</{block_tag}>",
            "invalid {block_tag}, colored {generic_tag}, text both" => "<{block_tag}>Example text with <{generic_tag} style='color: red'>COLORED EMPHASIS</{generic_tag}> and text after.</{block_tag}>",
            "invalid {block_tag{, bgcolor {generic_tag}, text both" => "<{block_tag}>Example text with <{generic_tag} style='background-color: red;'>BG COLORED EMPHASIS</{generic_tag}> and text after.</{block_tag}>",
            "invalid {block_tag}, colored {generic_tag}, text after" => "<{block_tag}><{generic_tag} style='color: red'>COLORED EMPHASIS</{generic_tag}> with text after.</{block_tag}>",
            "invalid {block_tag{, bgcolor {generic_tag}, text after" => "<{block_tag}><{generic_tag} style='background-color: red;'>BG COLORED EMPHASIS</{generic_tag}> with text after.</{block_tag}>",
        ];
    }
}
