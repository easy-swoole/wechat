<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/27
 * Time: 0:09
 */

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;


class File extends Message
{
    /**
     * @var string
     */
    protected $type = 'file';

    /**
     * File constructor.
     *
     * @param string $media_id
     */
    public function __construct(string $media_id)
    {
        parent::__construct(compact('media_id'));
    }
}