<?php

use CidiLabs\PhpAlly\PhpAlly;
use CidiLabs\PhpAlly\PhpAllyIssue;

class PhpAllyTest extends PhpAllyTestCase {

    public function testCheckOne()
    {
        $ally = new PhpAlly();
        $report = $ally->checkOne($this->getColorContrastHtml(), 'CssTextStyleEmphasize');
        $issues = $report->getIssues();
        $errors = $report->getErrors();
        $issue = reset($issues);

        $this->assertCount(2, $issues, 'Testcheckone should have 2 issues.');
        $this->phpAllyIssueTest($issue);
        $this->phpAllyReportTest($report);
    }

    public function testCheckMany() 
    {
        $ally = new PhpAlly();
        $report = $ally->checkMany($this->getManyHtml(), $ally->getRuleIds());
        $issues = $report->getIssues();
        $issue = reset($issues);
        
        $this->assertCount(5, $issues, 'Total report should have 5 issues.');
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