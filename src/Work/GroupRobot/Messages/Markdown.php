<?php

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;

/**
 * Class Markdown
 * @package EasySwoole\WeChat\Work\GroupRobot\Messages
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Markdown extends Message
{
    /**
     * @var string
     */
    protected $type = 'markdown';

    /**
     * Markdown constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        parent::__construct(compact('content'));
    }
}