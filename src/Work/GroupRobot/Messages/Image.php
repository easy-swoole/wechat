<?php

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;

/**
 * Class Image
 * @package EasySwoole\WeChat\Work\GroupRobot\Messages
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Image extends Message
{
    /**
     * @var string
     */
    protected $type = 'image';

    /**
     * Image constructor.
     *
     * @param string $base64
     * @param string $md5
     */
    public function __construct(string $base64, string $md5)
    {
        parent::__construct(compact('base64', 'md5'));
    }




}