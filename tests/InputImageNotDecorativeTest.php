<?php

use CidiLabs\PhpAlly\Rule\InputImageNotDecorative;

class InputImageNotDecorativeTest extends PhpAllyTestCase {
    public function testCheckTrue()
    {
        $html = '<div><form action="/action_page.php">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <input type="submit" value="Submit">
        </form></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new InputImageNotDecorative($dom);

        $this->assertEquals(0, $rule->check(), 'Image Has Long Description should have no issues.');
    }

    public function testCheckFalse()
    {
        $html = '<div><form action="/action_page.php">
        <label for="fname">First name:</label>
        <input type="image" id="fname" name="fname"><br><br>
        <input type="image" value="Submit">
        </form></div>';
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        $rule = new InputImageNotDecorative($dom);

        $this->assertEquals(2, $rule->check(), 'Image Has Long Description should have one issue.');
    }
}