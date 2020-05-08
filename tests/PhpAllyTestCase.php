<?php

use PHPUnit\Framework\TestCase;

class PhpAllyTestCase extends TestCase {

    protected function getLinkHtml()
    {
        return '<div style="background-color: #444">
            <p style="color: #000;">Paragraph text is here.</p>
            <a href="https://google.com"> </a>
            <a href="https://google.com">Click Here</a>
            <a href="https://google.com"> </a>
        </div>';
    }

    protected function getColorContrastHtml()
    {
        return '<div style="background-color: #444">
            <p style="color: #000";">Paragraph text does not have enough contrast.</p>
            <p style="color: #FFF";">Paragraph text does have enough contrast.</p>
            <p style="color: #00A";">Paragraph text has blue text, no contrast.</p>
        </div>';
    }

    protected function getTableHtml()
    {
        return '';
    }

    protected function getHeaderHtml()
    {
        return '';
    }

    protected function getImageHtml()
    {
        return '';
    }
}