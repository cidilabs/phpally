<?php

namespace CidiLabs\PhpAlly\Rule;

class IframeNotHandled extends BaseRule
{
    private $regex = array(
        '@youtube\.com/embed/([^"\&\? ]+)@i',
        '@youtube\.com/v/([^"\&\? ]+)@i',
        '@youtube\.com/watch\?v=([^"\&\? ]+)@i',
        '@youtube\.com/\?v=([^"\&\? ]+)@i',
        '@youtu\.be/([^"\&\? ]+)@i',
        '@youtu\.be/v/([^"\&\? ]+)@i',
        '@youtu\.be/watch\?v=([^"\&\? ]+)@i',
        '@youtu\.be/\?v=([^"\&\? ]+)@i',
        '@youtube-nocookie\.com/embed/([^"\&\? ]+)@i',
        '@vimeo\.com/[^0-9]*([0-9]{7,9})@i',
        '/(kaltura)/',
        '/(dailymotion)/',
    );

    public function id()
    {
        return self::class;
    }

    public function check()
    {
        foreach ($this->getAllElements('iframe') as $iframe) {
            $matches = false;

            foreach ($this->regex as $search) {
                if (preg_match($search, trim($iframe->getAttribute('src')))) {
                    $matches = true;
                    break;
                }
            }

            if (!$matches) {
                $this->setIssue($iframe);
            }
        }

        return count($this->issues);
    }
}
