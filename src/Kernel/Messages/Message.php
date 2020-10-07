<?php


namespace EasySwoole\WeChat\Kernel\Messages;


use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Utility\XML;

/**
 * Class Message
 *
 * @package EasySwoole\WeChat\Kernel\Messages
 */
abstract class Message extends SplBean implements MessageInterface
{
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

    protected $MsgType;
    protected $MsgId;
    protected $ToUserName;
    protected $FromUserName;
    protected $CreateTime;

    /**
     * @return mixed
     */
    public function getMsgId(): ?int
    {
        return $this->MsgId;
    }

    /**
     * @param mixed $id
     */
    public function setMsgId($id): void
    {
        $this->MsgId = $id;
    }

    /**
     * @return string|null
     */
    public function getToUserName(): ?string
    {
        return $this->ToUserName;
    }

    /**
     * @param mixed $to
     */
    public function setToUserName($to)
    {
        $this->ToUserName = $to;
    }

    /**
     * @return string|null
     */
    public function getFromUserName(): ?string
    {
        return $this->FromUserName;
    }

    /**
     * @param mixed $from
     */
    public function setFromUserName($from)
    {
        $this->FromUserName = $from;
    }

    /**
     * @return int|null
     */
    public function getCreateTime(): ? int
    {
        return $this->CreateTime;
    }

    /**
     * @param mixed $CreateTime
     */
    public function setCreateTime($CreateTime)
    {
        $this->CreateTime = $CreateTime;
    }


    /**
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->MsgType;
    }

    /**
     * @param string $MsgType
     */
    public function setMsgType(string $MsgType)
    {
        $this->MsgType = $MsgType;
    }

    /**
     * @param array $appends
     * @return array
     */
    public function transformForJsonRequest(array $appends = []): array
    {
        return array_merge($this->jsonSerialize(), $appends);
    }

    /**
     * @param array $appends
     * @return string
     */
    public function transformToXml(array $appends = []): string
    {
        return XML::build(array_merge($this->jsonSerialize(), $appends));
    }
}