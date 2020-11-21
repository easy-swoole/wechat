<?php


namespace EasySwoole\WeChat\Kernel\Messages;


use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Traits\HasAttributes;
use EasySwoole\WeChat\Kernel\Utility\XML;

/**
 * Class Message
 *
 * @package EasySwoole\WeChat\Kernel\Messages
 */
abstract class Message implements MessageInterface
{
    use HasAttributes;

    const VALIDATE = 'validate';
    const RAW = 'raw';
    const TEXT = 'text';
    const EVENT = 'event';
    const IMAGE = 'image';
    const MUSIC = 'music';
    const VOICE = 'voice';
    const VIDEO = 'video';
    const SHORT_VIDEO = 'shortvideo';
    const LOCATION = 'location';
    const LINK = 'link';
    const NEWS = 'news';

    /**
     * 客服发送消息中出现
     */
    const MPNEWS = 'mpnews';
    const MSGMENU = 'msgmenu';
    const WXCARD = 'wxcard';
    const MINIPROGRAMPAGE = 'miniprogrampage';

    /**
     * 群发消息中出现
     */
    const MPVIDEO = 'mpvideo';

    /** @var string */
    protected $type;

    /** @var string */
    protected $id;

    /** @var string */
    protected $to;

    /** @var string */
    protected $from;

    /** @var string */
    protected $createTime;

    /**
     * Message constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type):self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param $property
     * @return mixed|null
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return $this->getAttribute($property);
    }

    /**
     * @param $property
     * @param $value
     * @return $this
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            $this->setAttribute($property, $value);
        }

        return $this;
    }

    /**
     * @param array $appends
     * @return array
     */
    public function transformForJsonRequest(array $appends = []): array
    {
        return array_merge($this->all(), $appends);
    }

    /**
     * @param array $appends
     * @return string
     */
    public function transformToXml(array $appends = []): string
    {
        return XML::build(array_merge($this->all(), $appends));
    }
}