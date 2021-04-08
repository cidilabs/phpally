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

    protected function getManyHtml()
    {
        return '<div>
            <p style="color: #000;">Paragraph text is here.</p>
            <a href="https://google.com"> </a>
            <a href="https://google.com">Click Here</a>
            <a href="https://google.com"> </a>
            
            <p style="color: #0000FF";"><strong>Paragraph text does have enough contrast.</strong></p>

            <p style="color: #000";">Paragraph text does not have enough contrast.</p>
            <p style="color: #FFF";">Paragraph text does have enough contrast.</p>
            <p style="color: #00A";">Paragraph text has blue text, no contrast.</p>

            <video controls width="250"src="/media/examples/friday.mp4">
            <track default kind="captions"srclang="en"src="/media/examples/friday.vtt"/>
            Sorry, your browser doesnt support embedded videos.
            </video>


        </div>';
    }

    protected function getGoodColorContrastHtml()
    {
        return '<div style="background-color: #FFFFFF">
            <p style="color: #0000FF";"><strong>Paragraph text does have enough contrast.</strong></p>
        </div>';
    }

    protected function getColorContrastHtml()
    {
        return '<div style="background-color: #444"><p style="color: #000";">Paragraph text does not have enough contrast.</p><p style="color: #FFF";">Paragraph text does have enough contrast.</p><p style="color: #00A";">Paragraph text has blue text, no contrast.</p></div>';
    }

    protected function getGoodColorContrastRGBHtml(){
        return '<p style="background-color: rgb(64, 0, 100); color: rgb(169, 169, 169);">Paragraph text does not have enough contrast.</p>';
    }

    protected function getVideoTagHtml()
    {
        return '<div style="background-color: #444">
                <video controls width="250"src="/media/examples/friday.mp4">
                    <track default kind="captions"srclang="en"src="/media/examples/friday.vtt"/>
                    Sorry, your browser doesnt support embedded videos.
                </video>
            </div>';
    }

    protected function getBadVideoTagHtml()
    {
        return '<div style="background-color: #444">
                <video controls width="250"src="/media/examples/friday.mp4">
                    Sorry, your browser doesnt support embedded videos.
                </video>
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