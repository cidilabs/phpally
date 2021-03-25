<?php

use CidiLabs\PhpAlly\Rule\VideoCaptionsMatchCourseLanguage;

class VideoCaptionsMatchCourseLanguageTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><a href="https://www.youtube.com/watch?v=vFF0uV9AOB8">Valid Link</a></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoCaptionsMatchCourseLanguage($dom);

        $this->assertEquals(1, $rule->check(), 'Video Embed Check should have one issues.');
    }
}