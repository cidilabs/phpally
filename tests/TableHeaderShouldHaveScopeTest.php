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

        $this->assertEquals(3, $rule->check(), 'Table Data Should Have Scope should have one issue.');
    }
}