<?php

use CidiLabs\PhpAlly\PhpAlly;
use CidiLabs\PhpAlly\PhpAllyIssue;

class PhpAllyTest extends PhpAllyTestCase {

    public function testCheckOne()
    {
        $ally = new PhpAlly();
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45',
            'vimeoApiKey' => 'bef37736cfb26b6dc52986d8f531d0ad',
            'youtubeApiKey' => 'AIzaSyB5bTf8rbYwiM73k1rj8dDnwEalwTqdz_c'
        ];
        $report = $ally->checkOne($this->getColorContrastHtml(), 'CssTextStyleEmphasize', $options);
        $issues = $report->getIssues();
        $errors = $report->getErrors();
        $issue = reset($issues);

        $this->assertCount(1, $issues, 'Testcheckone should have 1 issues.');
        $this->phpAllyIssueTest($issue);
        $this->phpAllyReportTest($report);
    }

    public function testCheckMany() 
    {
        $ally = new PhpAlly();
        $options = [
            'backgroundColor' => '#ffffff',
            'textColor' => '#2D3B45',
            'vimeoApiKey' => 'bef37736cfb26b6dc52986d8f531d0ad',
            'youtubeApiKey' => 'AIzaSyB5bTf8rbYwiM73k1rj8dDnwEalwTqdz_c'
        ];
        $report = $ally->checkMany($this->getManyHtml(), $ally->getRuleIds(), $options);
        $issues = $report->getIssues();
        $issue = reset($issues);
        
        $this->assertCount(8, $issues, 'Total report should have 5 issues.');
        $this->phpAllyIssueTest($issue);
        $this->phpAllyReportTest($report);
    }

    
    protected function phpAllyReportTest($report)
    {
        $issues = $report->getIssues();
        
        foreach($issues as $issue) {
            $this->phpAllyIssueTest($issue);
        }
    }

    protected function phpAllyIssueTest(PhpAllyIssue $issue)
    {
        $this->assertEquals(PhpAllyIssue::class, get_class($issue), 'Issue is a PhpAllyIssue object.');
        $this->assertEquals(DOMElement::class, get_class($issue->getElement()), 'Issue returns a DomElement with getElement()');
        $this->assertEquals(DOMElement::class, get_class($issue->getPreviewElement()), 'Issue return DomElement for getPreviewElement()');
    }

}