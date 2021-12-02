<?php

use Cidilabs\PhpAlly\Rule\TableNotEmpty;

class TableNotEmptyTest extends PhpAllyTestCase {
    public function testTable()
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
        $rule = new TableNotEmpty($dom);

        $this->assertEquals(0, $rule->check(), 'TableNotEmpty should have no issues.');
    }

    public function testEmptyTable()
    {
        $html = '<table></table>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableNotEmpty($dom);

        $this->assertEquals(1, $rule->check(), 'TableNotEmpty should have one issue.');
    }

    public function testEmptyTableHeader()
    {
        $html = '<table><th></th></table>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableNotEmpty($dom);

        $this->assertEquals(1, $rule->check(), 'TableNotEmpty should have one issue.');
    }

    public function testEmptyTableRow()
    {
        $html = '<table><tr></tr></table>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableNotEmpty($dom);

        $this->assertEquals(1, $rule->check(), 'TableNotEmpty should have one issue.');
    }

    public function testMultipleEmptyTables()
    {
        $html = '<table></table><table></table>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableNotEmpty($dom);

        $this->assertEquals(2, $rule->check(), 'TableNotEmpty should have two issues.');
    }

    public function testNoTables()
    {
        $html = '<p>No tables here!</p>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new TableNotEmpty($dom);

        $this->assertEquals(0, $rule->check(), 'TableNotEmpty should have no issues.');
    }
}
