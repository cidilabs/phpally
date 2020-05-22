<?php

use CidiLabs\PhpAlly\Rule\BaseFontIsNotUsed;

class BaseFontIsNotUsedTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<head>
        </head>
        <body>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BaseFontIsNotUsed($dom);

        $this->assertEquals(0, $rule->check(), 'Base Font Is Not Used should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<head>
        <basefont color="red" face="Verdana, Geneva, sans-serif" size="12">
        </head>
        <body>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new BaseFontIsNotUsed($dom);

        $this->assertEquals(1, $rule->check(), 'Base Font Is Not Used should have one issue.');
    }
}