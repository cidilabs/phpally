<?php

use CidiLabs\PhpAlly\Rule\HeadersHaveText;

class HeadersHaveTextTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<!DOCTYPE html><body>
        <p>
            <h1>Heading</h1>
        </p>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadersHaveText($dom);

        $this->assertEquals(0, $rule->check(), 'Headers Have Text should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<!DOCTYPE html><body>
        <h1></h1>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadersHaveText($dom);

        $this->assertEquals(1, $rule->check(), 'Headers Have Text should have one issue.');
    }

    public function testCheckFalseSpace()
    {
        $html = '<!DOCTYPE html><body>
        <h1>   </h1>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadersHaveText($dom);

        $this->assertEquals(1, $rule->check(), 'Headers Have Text should have one issue.');
    }
}