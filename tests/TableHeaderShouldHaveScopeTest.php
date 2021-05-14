<?php

use CidiLabs\PhpAlly\Rule\TableHeaderShouldHaveScope;

class TableHeaderShouldHaveScopeTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '
            <table style="width:100%">
                <tr>
                    <th scope="row">Firstname</th>
                    <th scope="row">Lastname</th>
                    <th scope="row">Age</th>
                </tr>
                <tr>
                    <td>Jill</td>
                    <td>Smith</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>Eve</td>
                    <td>Jackson</td>
                    <td>94</td>
                </tr>
            </table>
        ';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableHeaderShouldHaveScope($dom);

        $this->assertEquals(0, $rule->check(), 'Table Data Should Have Scope should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '
            <table style="width:100%">
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                </tr>
                <tr>
                    <td>Jill</td>
                    <td>Smith</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>Eve</td>
                    <td>Jackson</td>
                    <td>94</td>
                </tr>
            </table>
        ';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableHeaderShouldHaveScope($dom);

        $this->assertEquals(1, $rule->check(), 'Table Data Should Have Scope should have one issue.');
    }

    public function testCheckFalseFullTable()
    {
        $html = '<table class="table">
        <tbody>
            <tr>
                <th data-title="ID" data-breakpoints="xs">1</th>
                <th scope="col">Dennise</th>
                <th scope="col">Fuhrman</th>
                <th scope="col" data-title="Job Title" data-breakpoints="xs">High School History Teacher</th>
                <th scope="col" data-title="Started On" data-breakpoints="xs sm">November 8th 2011</th>
                <th scope="col" data-title="Date of Birth" data-breakpoints="xs sm md">July 25th 1960</th>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Elodia</td>
                <td>Weisz</td>
                <td>Wallpaperer Helper</td>
                <td>October 15th 2010</td>
                <td>March 30th 1982</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Raeann</td>
                <td>Haner</td>
                <td>Internal Medicine Nurse Practitioner</td>
                <td>November 28th 2013</td>
                <td>February 26th 1966</td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>Junie</td>
                <td>Landa</td>
                <td>Offbearer</td>
                <td>October 31st 2010</td>
                <td>March 29th 1966</td>
            </tr>
            <tr>
                <th scope="row">5</th>
                <td>Solomon</td>
                <td>Bittinger</td>
                <td>Roller Skater</td>
                <td>December 29th 2011</td>
                <td>September 22nd 1964</td>
            </tr>
            <tr>
                <th scope="row">6</th>
                <td>Bar</td>
                <td>Lewis</td>
                <td>Clown</td>
                <td>November 12th 2012</td>
                <td>August 4th 1991</td>
            </tr>
            <tr>
                <th scope="row">7</th>
                <td>Usha</td>
                <td>Leak</td>
                <td>Ships Electronic Warfare Officer</td>
                <td>August 14th 2012</td>
                <td>November 20th 1979</td>
            </tr>
            <tr>
                <th scope="row">8</th>
                <td>Lorriane</td>
                <td>Cooke</td>
                <td>Technical Services Librarian</td>
                <td>September 21st 2010</td>
                <td>April 7th 1969</td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>fsf</p>';

    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTML($html);
    $rule = new TableHeaderShouldHaveScope($dom);

    $this->assertEquals(1, $rule->check(), 'Table Data Should Have Scope should have one issue.');
    }
}