<?php

use CidiLabs\PhpAlly\Rule\ObjectMustContainText;

class ObjectMustContainTextTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><object type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200">Media Application</object></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectMustContainText($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues.');
    }

    public function testCheckTrueAlt()
    {
        $html = '<div><object alt="media application" type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200"></object></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectMustContainText($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><object type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200"></object></div>';;
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectMustContainText($dom);

        $this->assertEquals(1, $rule->check(), 'Object Must Contain Text should have one issue.');
    }

    public function testCheckAriaLabel()
    {
        $html = '<div><object aria-label="label" type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200"></object></div>';;
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectMustContainText($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues');
    }

    public function testCheckAriaLabeledBy()
    {
        $html = '<div><object aria-labelledby="label" type="application/pdf"data="/media/examples/In-CC0.pdf"width="250"height="200"></object></div>';;
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new ObjectMustContainText($dom);

        $this->assertEquals(0, $rule->check(), 'Object Must Contain Text should have no issues');
    }
}