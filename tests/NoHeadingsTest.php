<?php

use CidiLabs\PhpAlly\Rule\NoHeadings;

class NoHeadingsTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<!DOCTYPE html><body>
        <p>
            <h1>Heading</h1>
        </p>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new NoHeadings($dom);

        $this->assertEquals(0, $rule->check(), 'No Headings Test should have no issues.');
    }

    public function testCheckTrueTooShort()
    {
        $html = '<!DOCTYPE html><body>
        <p>
        </p>
        </body>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new NoHeadings($dom);

        $this->assertEquals(0, $rule->check(), 'No Headings Test should have one issue.');
    }

    public function testCheckFalse()
    {
        $html = file_get_contents(__DIR__ . '/../tests/testFiles/ContentTooLong.html');
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new NoHeadings($dom);

        $this->assertEquals(1, $rule->check(), 'No Headings Test should have one issue.');
    }
}