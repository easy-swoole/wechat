<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Text extends Message
{
    /** @var string */
    protected $type = Message::TEXT;

    /**
     * Text constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        parent::__construct(['content' => $content]);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->get('content');
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->set('content', $content);
    }

    /**
     * @return array
     */
    public function toXmlArray(): array
    {
        return [
            "Content" => $this->get('content')
        ];
    }
}
