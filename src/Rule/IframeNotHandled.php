<?php

namespace CidiLabs\PhpAlly\Rule;

class IframeNotHandled extends BaseRule
{
    public function id()
    {
        return self::class;
    }

    public function check()
    {
        $search = '/(youtube|youtu.be|vimeo|kaltura|dailymotion)/';

        foreach ($this->getAllElements('iframe') as $iframe) {
            if (!preg_match($search, $iframe->getAttribute('src'))) {
                $this->setIssue($iframe);
            }
        }
    }
}
