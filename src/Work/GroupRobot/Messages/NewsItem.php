<?php

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;

/**
 * Class NewsItem
 * @package EasySwoole\WeChat\Work\GroupRobot\Messages
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class NewsItem extends Message
{
    /**
     * @var string
     */
    protected $type = 'news';

    public function toJsonArray()
    {
        return [
            'title' => $this->get('title'),
            'description' => $this->get('description'),
            'url' => $this->get('url'),
            'picurl' => $this->get('image'),
        ];
    }

    public function transformForJsonRequest(array $appends = []): array
    {
        return [
            'msgtype' => $this->getType(),
            $this->getType() => [
                'articles' => [$this->toJsonArray()]
            ]
        ];
    }
}