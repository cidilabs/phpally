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
            <a href="https://www.google.com/"> </a>
            <a href="https://www.google.com/">Click Here</a>
            <a href="https://www.google.com/"> </a>

            <p style="color: #0000FF";"><strong>Paragraph text does have enough contrast.</strong></p>

            <p>Paragraph text <span style="color: #000">has</span> enough contrast.</p>
            <p style="color: #FFF">Paragraph text NOT does have enough contrast.</p>
            <p style="color: #00A">Paragraph text has blue text, no contrast.</p>

            <video controls width="250"src="/media/examples/friday.mp4">
            <track default kind="captions" srclang="en" src="/media/examples/friday.vtt"/>
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

    protected function getEphasisPass()
    {
        return '<p style="color: #008000; background-color: #ffffff;"><em><strong>Testing</strong></em></p>';
    }

    protected function getColorContrastHtml()
    {
        return '<div style="background-color: #444; background: no-repeat fixed center;"><p style="color: #000";">Paragraph text does not have enough contrast.</p><p style="color: #FFF";">Paragraph text does have enough contrast.</p><p style="color: #00A";">Paragraph text has blue text, no contrast.</p></div>';
    }

    protected function getColorEmphasisHtml()
    {
        return '<p>Text does not have <span style="color: red">correct emphasis</span>.</p>';
    }

    protected function getGoodBackgroundContrastColorNameHtml()
    {
        return '<span id="kl_popup_2_content" class="kl_tooltip_content kl_popup_content bs-badge bs-badge-dark" style="background: green no-repeat fixed center; color: rgb(255, 255, 255); padding: 2px 5px; font-weight: normal; font-style: normal;">Some Tooltip Text</span>';
    }

    protected function getBadBackgroundContrastColorNameHtml()
    {
        return '<span id="kl_popup_2_content" class="kl_tooltip_content kl_popup_content bs-badge bs-badge-dark" style="background: white no-repeat fixed center; color: rgb(255, 255, 255); padding: 2px 5px; font-weight: normal; font-style: normal;">Some Tooltip Text</span>';
    }

    protected function getGoodBackgroundContrastRgbHtml()
    {
        return '<span id="kl_popup_2_content" class="kl_tooltip_content kl_popup_content bs-badge bs-badge-dark" style="background: rgb(0,0,0) no-repeat fixed center; color: rgb(255, 255, 255); padding: 2px 5px; font-weight: normal; font-style: normal;">Some Tooltip Text</span>';
    }

    protected function getBadBackgroundContrastRgbHtml()
    {
        return '<span id="kl_popup_2_content" class="kl_tooltip_content kl_popup_content bs-badge bs-badge-dark" style="background: rgb(255,255,255) no-repeat fixed center; color: rgb(255, 255, 255); padding: 2px 5px; font-weight: normal; font-style: normal;">Some Tooltip Text</span>';
    }

    protected function getGoodColorContrastRGBHtml(){
        return '<p style="background-color: rgb(64, 0, 100); color: rgb(169, 169, 169);">Paragraph text does not have enough contrast.</p>';
    }

    protected function getbackgroundVarHtml(){
        return '<span style="color: var(--dt-color-primary-contrast); background-color: var(--dt-color-primary); font-size: 1.8em;"> Captioning Challenge</span>';
    }

    protected function getScopedColors(){
        return '<div style="background-color: #444; color: #000;">
        <div>
        <p style="color: #444;"> test </p>
        <p style="color: #444;"> test </p>
        <div>
            <p style="color: #444;"> test </p>
            <p style="color: #444;"> test 2 </p>
            <p style="color: #444;"> test 3 </p>
        </div>
        </div>
        </div>
        ';
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

    public function getDesignPlusHtml()
    {
        return '<div style="background-color:#2D3B45;" id="dp-wrapper" class="dp-wrapper dp-heading-color-border-h2-dp-primary dp-heading-border-h2-heavy dp-heading-icon-text-h2-dp-primary dp-heading-icon-text-h3-dp-primary dp-heading-icon-text-h4-dp-primary dp-heading-icon-text-h5-dp-primary dp-heading-icon-text-h6-dp-primary dp-heading-color-border-h3-dp-primary dp-heading-color-border-h4-dp-primary dp-heading-color-border-h5-dp-primary dp-heading-color-border-h6-dp-primary dp-heading-base-h2-bottom-border dp-heading-base-h3-bottom-border dp-heading-base-h4-bottom-border dp-heading-base-h5-bottom-border dp-heading-base-h6-bottom-border dp-heading-border-h3-mid dp-heading-border-h4-light dp-heading-display-h5-table dp-heading-display-h6-table">
        <h2>DesignPLUS - Next Generation Alpha Testing</h2>
        <h3 class="dp-has-icon"><i class="dp-icon fas fa-folder-open" aria-hidden="true"> </i> Background</h3>
        <p>Over the last five years since the release of DesignPLUS, we have received loads of general customer comments, feature requests, and thoughts on tool limitations. Without a doubt, we have learned a great deal from our users. We have also learned over time about more sustainable frameworks for DesignPLUS, more efficient building and maintenance strategies, and more ways to improve the overall user experience. Three years of planning and development have led us, finally, to the Alpha Testing stage.&nbsp;</p>
        <h3 class="dp-has-icon"><i class="dp-icon fas fa-check-circle" aria-hidden="true"> </i> Goals for Alpha Testing&nbsp;</h3>
        <p>The purpose of this initial round of testing is to:&nbsp;</p>
        <ul>
            <li aria-level="1"><span>Determine how intuitive the new user experience is to you</span></li>
            <li aria-level="1"><span>Understand any challenges that you encounter in using DP-NG</span></li>
            <li aria-level="1"><span>Identify ways that Cidi Labs can ease the transition from Legacy DesignPLUS to DP-NG</span></li>
            <li aria-level="1"><span>Note any inconsistencies across the tools and/or missing features&nbsp;</span><br />
                <ul>
                    <li aria-level="1">The <a title="Alpha Testing Release Notes" href="https://cidilabs.instructure.com/courses/7288/pages/alpha-testing-release-notes" data-api-endpoint="https://cidilabs.instructure.com/api/v1/courses/7288/pages/alpha-testing-release-notes" data-api-returntype="Page"><span>Alpha Testing Release Notes</span></a> page can help you see feature parity, new features, and known issues&nbsp;</li>
                </ul>
            </li>
        </ul>
        <h3 class="dp-has-icon"><i class="dp-icon fas fa-clipboard-list" aria-hidden="true"> </i> Tasks</h3>
        <p>Use the pages in your own module to complete each corresponding task. If you create additional pages or other content, please follow the naming convention "[Your Last Name] - [Content Title]." Be sure to add any new content you create to your own module.&nbsp;</p>
        <p><a class="btn btn-dp-primary" href="https://docs.google.com/document/d/1_Kk4a7EsDDrQLdHIexkizVZVjuzAAIz71WqdH6dN8yc/edit#" target="_blank" rel="noopener">Open this document to view instructions for tasks.</a></p>
        <div class="dp-content-block dp-rce-highlight">
            <h3 class="dp-has-icon"><i class="dp-icon fas fa-file-signature" aria-hidden="true"> </i> Terms</h3>
                <li aria-level="2">
                    <p><span style="font-size: 12pt;">Participants will treat the software as confidential and will not demonstrate, copy, sell or market the software to any third party; or p</span><span style="font-size: 12pt;">ublish or otherwise disclose information relating to performance or quality of the Software to any third party.</span></p>
                </li>
                <li aria-level="2">
                    <p><span style="font-size: 12pt;">Participants will not modify, reuse, disassemble, decompile, reverse engineer or otherwise translate the software or any portion thereof. </span></p>
                </li>
                <li>Participants understand that the s<span>oftware is prerelease code and is not at the level of performance or compatibility of a final, generally available product offering. Software may be substantially modified prior to general availability.&nbsp;&nbsp;</span></li>
            </ul>
            <h3 class="dp-has-icon"><i class="dp-icon fas fa-question-circle" aria-hidden="true"> </i> Need Help?</h3>
        </div>
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
