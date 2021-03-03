<?php


namespace EasySwoole\WeChat\Kernel\Messages;


use EasySwoole\Utility\Str;
use EasySwoole\WeChat\Kernel\Contracts\MediaInterface;

class Media extends Message implements MediaInterface
{
    /** @var string */
    protected $mediaId;

    /**
     * Media constructor.
     * @param string $mediaId
     * @param null $type
     */
    public function __construct(string $mediaId, $type = null)
    {
        parent::__construct(['media_id' => $mediaId]);

        !empty($type) && $this->setType($type);
    }

    /**
     * @return string
     */
    public function getMediaId(): string
    {
        return $this->mediaId;
    }

    /**
     * @return array[]
     */
    public function toXmlArray(): array
    {
        return [
            Str::studly($this->getType()) => [
                'MediaId' => $this->get('media_id'),
            ],
        ];
    }
}
