<?php

use CidiLabs\PhpAlly\Rule\DocumentReadingDirection;

class DocumentReadingDirectionTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<a><h1>The text in Hebrew is</h1><h1 lang="he" dir="rtl">אָלֶף־בֵּית עִבְרִי</h1></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new DocumentReadingDirection($dom);

        $this->assertEquals(0, $rule->check(), 'Document Reading Direction should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<a><h1>The text in Hebrew is</h1><h1 lang="he" dir="">אָלֶף־בֵּית עִבְרִי</h1></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new DocumentReadingDirection($dom);

        $this->assertEquals(1, $rule->check(), 'Document Reading Direction should have one issue.');
    }

    public function testCheckFalseComplex()
    {
        $html = '<a><h1>The text in Hebrew is</h1><h1 lang="he" dir="rtl">אָלֶף־בֵּית עִבְרִי</h1><h1 dir="ltr">Left to right again</h1>
        <h1 lang="he" dir="">אָלֶף־בֵּית עִבְרִי</h1></a>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new DocumentReadingDirection($dom);

        $this->assertEquals(1, $rule->check(), 'Document Reading Direction should have one issue.');
    }
}