<?php

namespace EasySwoole\WeChat\OfficialAccount\Broadcasting;

use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;

/**
 * Class MessageBuilder
 * @package EasySwoole\WeChat\OfficialAccount\Broadcasting
 */
class MessageBuilder
{
    /**
     * @var array
     */
    protected $to = [];

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @param MessageInterface $message
     * @return $this
     */
    public function message(MessageInterface $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param array $to
     * @return $this
     */
    public function to(array $to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param int $tagId
     * @return $this
     */
    public function toTag(int $tagId)
    {
        $this->to([
            'filter' => [
                'is_to_all' => false,
                'tag_id' => $tagId,
            ],
        ]);

        return $this;
    }

    /**
     * @param array $openidList
     * @return $this
     */
    public function toUsers(array $openidList)
    {
        $this->to([
            'touser' => $openidList,
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function toAll()
    {
        $this->to([
            'filter' => ['is_to_all' => true],
        ]);

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function with(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $prepends
     * @return array
     * @throws RuntimeException
     */
    public function build(array $prepends = []): array
    {
        if (empty($this->message)) {
            throw new RuntimeException('No message content to send.');
        }

        $content = $this->message->transformForJsonRequest();

        if (empty($prepends)) {
            $prepends = $this->to;
        }

        $messageType = $this->message->getType();
        $data = [
            $messageType => $content,
            'msgtype' => $messageType
        ];

        return array_merge($prepends, $data, $this->attributes);
    }

    /**
     * @param string $by
     * @param string $user
     * @return array
     * @throws RuntimeException
     */
    public function buildForPreview(string $by, string $user): array
    {
        return $this->build([$by => $user]);
    }
}
