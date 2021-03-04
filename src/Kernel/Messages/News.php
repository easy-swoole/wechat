<?php


namespace EasySwoole\WeChat\Kernel\Messages;


/**
 * Class News
 * @package EasySwoole\WeChat\Kernel\Messages
 * @property NewsItem[] $items
 */
class News extends Message
{
    protected $type = Message::NEWS;

    public function __construct(array $items = [])
    {
        parent::__construct(['items' => $items]);
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

    public function toXmlArray(): array
    {
        $items = [];

        foreach ($this->get('items') as $item) {
            if ($item instanceof NewsItem) {
                $items[] = $item->toXmlArray();
            }
        }

        return [
            'ArticleCount' => count($items),
            'Articles' => $items,
        ];
    }
}
