<?php

use CidiLabs\PhpAlly\Rule\FontIsNotUsed;

class FontIsNotUsedTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<body>
        <p>Your formatted text goes here</p>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new FontIsNotUsed($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<body>
        <p><font color="red" face="Verdana, Geneva, sans-serif" size="+1">Your formatted text goes here</font></p>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new FontIsNotUsed($dom);

        $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have one issue.');
    }
}