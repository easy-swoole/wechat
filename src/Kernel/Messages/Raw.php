<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Raw extends Message
{
    /** @var string  */
    protected $type = Message::RAW;

    /**
     * Raw constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        parent::__construct(['Content' => $content]);
    }

    /**
     * @return mixed
     */
    public function getContent(): string
    {
        return $this->get('Content') ?? "";
    }

    /**
     * @param string $Content
     * @return $this
     */
    public function setContent(string $Content): self
    {
        $this->set('Content', $Content);
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->getContent();
    }
}