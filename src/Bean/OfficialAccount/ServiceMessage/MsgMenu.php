<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 23:02
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class MsgMenu extends RequestedReplyMsg
{
    protected $msgmenu = [];
    protected $msgtype = RequestConst::MSG_TYPE_MSGMENU;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {

        $data = $this->toArray(null, MsgMenu::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return null|string
     */
    public function getHeadContent() : ?string
    {
        return $this->msgmenu['head_content'] ?? null;
    }

    /**
     * @param array $headContent
     */
    public function setHeadContent(string $headContent)
    {
        $this->msgmenu['head_content'] = $headContent;
    }

    /**
     * @return array|null
     */
    public function getList() : ?array
    {
        return $this->msgmenu['list'] ?? [];
    }

    /**
     * @param array $list
     *
     * @return array
     */
    public function setList(array $list)
    {
        return $this->msgmenu['list'] = $list;
    }

    /**
     * @return null|string
     */
    public function getTailContent() : ?string
    {
        return $this->msgmenu['tail_content'] ?? null;
    }


    public function setTailContent(string $tailContent)
    {
        $this->msgmenu['tail_content'] = $tailContent;
    }

}