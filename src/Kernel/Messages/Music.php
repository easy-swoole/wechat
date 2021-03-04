<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Music extends Message
{
    protected $type = Message::MUSIC;

    public function toXmlArray(): array
    {
        $music = [
            'Music' => [
                'Title' => $this->get('title'),
                'Description' => $this->get('description'),
                'MusicUrl' => $this->get('url'),
                'HQMusicUrl' => $this->get('hq_url'),
            ],
        ];
        if ($thumbMediaId = $this->get('thumb_media_id')) {
            $music['Music']['ThumbMediaId'] = $thumbMediaId;
        }

        return $music;
    }
}
