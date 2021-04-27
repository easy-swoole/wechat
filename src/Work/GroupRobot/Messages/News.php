<?php

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;

/**
 * Class News
 * @package EasySwoole\WeChat\Work\GroupRobot\Messages
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class News extends Message
{
    /**
     * @var string
     */
    protected $type = 'news';

    /**
     * News constructor.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct(compact('items'));
    }

    /**
     * @return NewsItem[]
     */
    public function getItems(): array
    {
        return $this->get('items', []);
    }

    /**
     * @param NewsItem[] $items
     * @return $this
     */
    public function setItems(array $items): self
    {
        $this->set('items', $items);
        return $this;
    }

    public function transformForJsonRequest(array $appends = []): array
    {
        return [
            'msgtype' => $this->getType(),
            $this->getType() => [
                'articles' => array_map(
                    function ($item) {
                        if ($item instanceof NewsItem) {
                            return $item->toJsonArray();
                        }
                    },
                    $this->get('items')
                )
            ]
        ];
    }
}