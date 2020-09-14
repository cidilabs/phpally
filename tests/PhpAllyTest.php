<?php

use CidiLabs\PhpAlly\PhpAlly;
use CidiLabs\PhpAlly\PhpAllyIssue;

class PhpAllyTest extends PhpAllyTestCase {
    public function testCheckOne()
    {
        $ally = new PhpAlly();
        $report = $ally->checkOne($this->getLinkHtml(), 'AnchorMustContainText');
        $issues = $report->getIssues();
        $issue = reset($issues);

        $this->phpAllyReportTest($report);
        $this->phpAllyIssueTest($issue);
    }

    public function testCheckMany() 
    {
        $ally = new PhpAlly();
        $report = $ally->checkMany($this->getLinkHtml(), ['AnchorMustContainText']);
        $issues = $report->getIssues();
        $issue = reset($issues);

        $this->phpAllyReportTest($report);
        $this->phpAllyIssueTest($issue);
    }

    
    protected function phpAllyReportTest($report)
    {
        $issues = $report->getIssues();
        $this->assertCount(2, $issues, 'AnchorMustContainText test has two issues.');

        $this->assertCount(0, $report->getErrors(), 'AnchorMustContainText test has no errors');
        $report->setError('Testing error');
        $this->assertCount(1, $report->getErrors(), 'Report now has an error.');
    }

    protected function phpAllyIssueTest(PhpAllyIssue $issue)
    {
        $this->assertEquals(PhpAllyIssue::class, get_class($issue), 'Issue is a PhpAllyIssue object.');
        $this->assertEquals(DOMElement::class, get_class($issue->getElement()), 'Issue returns a DomElement with getElement()');
        $this->assertEquals(DOMElement::class, get_class($issue->getPreviewElement()), 'Issue return DomElement for getPreviewElement()');
    }

}