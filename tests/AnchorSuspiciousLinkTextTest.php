<?php

use CidiLabs\PhpAlly\Rule\AnchorSuspiciousLinkText;

class AnchorSuspiciousLinkTextTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><p><a href="https://cnn.com">Valid Link</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorSuspiciousLinkText($dom);

        $this->assertEquals(0, $rule->check(), 'Anchor Suspicious Link Test should have no issues.');
    }

    /**
	*	Checks the case where suspicious text such as "Click Here" is present in the anchor tag
	*/
    public function testCheckFalseSuspiciousTextCase()
    {
        $html = '<div><p><a href="https://cnn.com">Click Here</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorSuspiciousLinkText($dom);

        $this->assertEquals(1, $rule->check(), 'Anchor Suspicious Link Test should have one issue.');
    }

    /**
	*	Checks the case where suspicious text in another language is present
	*/
    public function testCheckFalseSuspiciousTextCaseOtherLanguage()
    {
        $html = '<div><p><a href="https://cnn.com">haga clic</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorSuspiciousLinkText($dom);
        $rule->setLanguage('es');

        $this->assertEquals(1, $rule->check(), 'Anchor Suspicious Link Test should have one issue.');
    }

    /**
	*	Checks the case where the name of the link is also found in the text of the anchor tag
	*/
    public function testCheckFalseLinkAsTextCase()
    {
        $html = '<div><p><a href="https://cnn.com">https://cnn.com</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorSuspiciousLinkText($dom);

        $this->assertEquals(1, $rule->check(), 'Anchor Suspicious Link Test should have one issue.');
    }

    /**
	*	Checks the case where the link is just an anchor and has no href attribute
	*/
    public function testCheckTrueAnchorCase()
    {
        $html = '<div><p><a name="anchor">Click Here</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorSuspiciousLinkText($dom);

        $this->assertEquals(0, $rule->check(), 'Anchor Suspicious Link Test should have no issues.');
    }

    /**
     *  Checks the case where the link text starts with https 
     */
    public function testCheckFalseTextIsLinkCase()
    {
        $html = '<div><p><a href="https://cnn.com">https://msn.com</a></p></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new AnchorSuspiciousLinkText($dom);

        $this->assertEquals(0, $rule->check(), 'Anchor Suspicious Link Test should have no issues.');
    }
}