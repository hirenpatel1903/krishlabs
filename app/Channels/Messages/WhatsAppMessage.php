<?php

namespace App\Channels\Messages;

class WhatsAppMessage
{
    public $content;
    public $mediaUrl;

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }
    public function mediaUrl($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;

        return $this;
    }
}
