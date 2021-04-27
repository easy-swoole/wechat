<?php

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;

/**
 * Class Text
 * @package EasySwoole\WeChat\Work\GroupRobot\Messages
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Text extends Message
{
    /**
     * @var string
     */
    protected $type = 'text';

    /**
     * Text constructor.
     *
     * @param string $content
     * @param string|array $userIds
     * @param string|array $mobiles
     */
    public function __construct(string $content, $userIds = [], $mobiles = [])
    {
        parent::__construct([
            'content' => $content,
            'mentioned_list' => (array)$userIds,
            'mentioned_mobile_list' => (array)$mobiles,
        ]);
    }

    /**
     * @param array $userIds
     *
     * @return Text
     */
    public function mention($userIds)
    {
        $this->set('mentioned_list', (array)$userIds);

        return $this;
    }

    /**
     * @param array $mobiles
     *
     * @return Text
     */
    public function mentionByMobile($mobiles)
    {
        $this->set('mentioned_mobile_list', (array)$mobiles);

        return $this;
    }
}