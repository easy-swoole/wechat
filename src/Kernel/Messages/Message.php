<?php


namespace EasySwoole\WeChat\Kernel\Messages;


use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Traits\HasAttributes;
use EasySwoole\WeChat\Kernel\Utility\XML;
use \ArrayAccess;
use \IteratorAggregate;
use \ArrayIterator;


/**
 * Class Message
 *
 * @package EasySwoole\WeChat\Kernel\Messages
 */
abstract class Message implements MessageInterface, ArrayAccess, IteratorAggregate
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
    const FILE = 'file';
    const TASK_CARD = 'taskcard';
    const TEXT_CARD = 'textcard';

    const DEVICE_EVENT = 'device_event';
    const DEVICE_TEXT = 'device_text';

    /**
     * 客服发送消息中出现
     */
    const MPNEWS = 'mpnews';
    const MSGMENU = 'msgmenu';
    const WXCARD = 'wxcard';
    const MINIPROGRAMPAGE = 'miniprogrampage';
    const TRANSFER_CUSTOMER_SERVICE = "transfer_customer_service";

    /**
     * 群发消息中出现
     */
    const MPVIDEO = 'mpvideo';


    const MINIPROGRAMPAGE_NOTICE = 'miniprogrampage_notice';
    const MINIPROGRAMPAGE_PAGE = 'miniprogrampage_page';


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
    public function setType(string $type): self
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
     * @throws InvalidArgumentException
     */
    public function transformForJsonRequest(array $appends = []): array
    {
        return array_merge($this->all(), $appends);
    }

    /**
     * @param array $appends
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function transformToXml(array $appends = []): string
    {
        return XML::build(array_merge($this->all(), $this->toXmlArray(), $appends));
    }

    /**
     * @return array
     * @throws RuntimeException
     */
    public function toXmlArray(): array
    {
        throw new RuntimeException(sprintf('Class "%s" cannot support transform to XML message.', __CLASS__));
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }
}
