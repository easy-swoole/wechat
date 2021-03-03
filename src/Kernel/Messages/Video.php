<?php


namespace EasySwoole\WeChat\Kernel\Messages;

/**
 * Class Video
 * @property string $video
 * @property string $title
 * @property string $media_id
 * @property string $description
 * @property string $thumb_media_id
 * @package EasySwoole\WeChat\Kernel\Messages
 */
class Video extends Media
{
    protected $type = Message::VIDEO;

    /**
     * Video constructor.
     * @param string $mediaId
     */
    public function __construct(string $mediaId)
    {
        parent::__construct($mediaId, 'video');
    }

    public function toXmlArray(): array
    {
        return [
            'Video' => [
                'MediaId' => $this->get('media_id'),
                'Title' => $this->get('title'),
                'Description' => $this->get('description'),
            ],
        ];
    }
}
