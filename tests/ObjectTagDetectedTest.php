<?php

use CidiLabs\PhpAlly\Rule\ObjectTagDetected;

class ObjectTagDetectedTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><object type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200">Media Application</object></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectTagDetected($dom);

        $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><object type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200"></object></div>';
        $html .= '<div><object type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200"></object></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectTagDetected($dom);

        $this->assertEquals(2, $rule->check(), 'Object Must Contain Text should have one issue.');
    }
}