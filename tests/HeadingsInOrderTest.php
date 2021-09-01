<?php

use CidiLabs\PhpAlly\Rule\HeadingsInOrder;

class HeadingsInOrderTest extends PhpAllyTestCase
{

    public function testNoHeaders()
    {
        $html = '<p></p>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(0, $rule->check(), 'HeadersInOrder should have no issues.');
    }

    public function testSingleH1()
    {
        $html = '<h1></h1>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(0, $rule->check(), 'HeadersInOrder should have no issues.');
    }

    public function testSingleH2()
    {
        $html = '<h2></h2>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(0, $rule->check(), 'HeadersInOrder should have no issues.');
    }

    public function testSingleH3()
    {
        $html = '<h3></h3>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSingleH4()
    {
        $html = '<h4></h4>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSingleH5()
    {
        $html = '<h5></h5>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSingleH6()
    {
        $html = '<h6></h6>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSkipH2()
    {
        $html = '<h1></h1><h3></h3>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSkipH3()
    {
        $html = '<h2></h2><h4></h4>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSkipTwoLevels()
    {
        $html = '<h2></h2><h5></h5>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(1, $rule->check(), 'HeadersInOrder should have one issue.');
    }

    public function testSkipLevelsTwice()
    {
        $html = '<h2></h2><h4></h4><h6></h6>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(2, $rule->check(), 'HeadersInOrder should have two issues.');
    }

    public function testMaintainLevel()
    {
        $html = '<h1></h1></h2><h2></h2>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(0, $rule->check(), 'HeadersInOrder should have no issues.');
    }

    public function testDecreaseLevel()
    {
        $html = '<h1></h1><h2></h2><h1></h1>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new HeadingsInOrder($dom);

        $this->assertEquals(0, $rule->check(), 'HeadersInOrder should have no issues.');
    }
}
