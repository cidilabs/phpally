<?php

use CidiLabs\PhpAlly\Rule\VideoCaptionsMatchCourseLanguage;

class VideoCaptionsMatchCourseLanguageTest extends PhpAllyTestCase {
    public function testCheckOneIssueWrongLanguage()
    {
        $html = '<div><a href="https://www.youtube.com/watch?v=vFF0uV9AOB8">Valid Link</a></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoCaptionsMatchCourseLanguage($dom);

        $this->assertEquals(1, $rule->check(), 'Video Embed Check should have one issues.');
    }

    public function testCheckNoIssuesRightLanguage()
    {
        $html = '<div><a href="https://www.youtube.com/watch?v=vFF0uV9AOB8">Valid Link</a></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $options = [];
        $options['lang'] = 'es';
        $rule = new VideoCaptionsMatchCourseLanguage($dom, $options);

        $this->assertEquals(0, $rule->check(), 'Video Embed Check should have one issues.');
    }

    public function testCheckNoIssuesAsrTrack()
    {
        $html = '<div><a href="https://www.youtube.com/watch?v=MJ4DtLnTPvY">Valid Link</a></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new VideoCaptionsMatchCourseLanguage($dom);

        $this->assertEquals(0, $rule->check(), 'Video Embed Check should have no issues.');
    }
}