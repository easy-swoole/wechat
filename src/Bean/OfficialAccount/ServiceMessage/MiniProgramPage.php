<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 23:37
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class MiniProgramPage extends RequestedReplyMsg
{
    protected $miniprogrampage = [];
    protected $customservice   = [];
    protected $msgtype         = RequestConst::MSG_TYPE_MINIPROGRAMPAGE;
    protected $sendWay         = ['touser', 'msgtype', 'miniprogrampage'];

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray($this->sendWay, MiniProgramPage::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param $kfAccount
     */
    public function setKfAccount($kfAccount)
    {
        $this->sendWay                     = ['touser', 'msgtype', 'miniprogrampage', 'customservice'];
        $this->customservice['kf_account'] = $kfAccount;
    }

    /**
     * @return mixed
     */
    public function getTitle() : ?string
    {
        return $this->miniprogrampage['title'] ?? null;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title) : void
    {
        $this->miniprogrampage['title'] = $title;
    }

    /**
     * @return mixed
     */
    public function getAppid() : ?string
    {
        return $this->miniprogrampage['appid'] ?? null;
    }

    /**
     * @param mixed $appid
     */
    public function setAppid(string $appid) : void
    {
        $this->miniprogrampage['appid'] = $appid;
    }

    /**
     * @return mixed
     */
    public function getPagepath() : ?string
    {
        return $this->miniprogrampage['pagepath'] ?? null;
    }

    /**
     * @param mixed $pagepath
     */
    public function setPagepath(string $pagepath) : void
    {
        $this->miniprogrampage['pagepath'] = $pagepath;
    }

    /**
     * @return mixed
     */
    public function getThumbMediaId() : ?string
    {
        return $this->miniprogrampage['thumb_media_id'] ?? null;
    }

    /**
     * @param mixed $thumbMediaId
     */
    public function setThumbMediaId(string $thumbMediaId) : void
    {
        $this->miniprogrampage['thumb_media_id'] = $thumbMediaId;
    }

}