<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:43 AM
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class QrCodeRequest extends SplBean
{
    const QR_SCENE = 'QR_SCENE';
    const QR_STR_SCENE = 'QR_STR_SCENE';
    const QR_LIMIT_SCENE = 'QR_LIMIT_SCENE';
    const QR_LIMIT_STR_SCENE = 'QR_LIMIT_STR_SCENE';

    protected $expire_seconds;
    protected $action_name;
    protected $action_info;
    protected $scene_id;
    protected $scene_str;

    /**
     * @return mixed
     */
    public function getExpireSeconds()
    {
        return $this->expire_seconds;
    }

    /**
     * @param mixed $expire_seconds
     */
    public function setExpireSeconds($expire_seconds): void
    {
        $this->expire_seconds = $expire_seconds;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->action_name;
    }

    /**
     * @param mixed $action_name
     */
    public function setActionName($action_name): void
    {
        $this->action_name = $action_name;
    }

    /**
     * @return mixed
     */
    public function getActionInfo()
    {
        return $this->action_info;
    }

    /**
     * @param mixed $action_info
     */
    public function setActionInfo($action_info): void
    {
        $this->action_info = $action_info;
    }

    /**
     * @return mixed
     */
    public function getSceneId()
    {
        return $this->scene_id;
    }

    /**
     * @param mixed $scene_id
     */
    public function setSceneId($scene_id): void
    {
        $this->scene_id = $scene_id;
    }

    /**
     * @return mixed
     */
    public function getSceneStr()
    {
        return $this->scene_str;
    }

    /**
     * @param mixed $scene_str
     */
    public function setSceneStr($scene_str): void
    {
        $this->scene_str = $scene_str;
    }

    /**
     * @return array
     */
    public function buildRequest(): array
    {
        if (is_string($this->getActionInfo())) {
            $this->action_info = json_decode($this->action_info, true);
        }

        $columns = ['action_name', 'action_info'];

        if (!is_null($this->expire_seconds) && is_numeric($this->expire_seconds)) {
            $this->expire_seconds = min($this->expire_seconds, 30 * 86400);
            array_push($columns,'expire_seconds');
        }

        if (!is_null($this->getActionInfo())) {
            return parent::toArray($columns);
        }

        $scene = [];
        if (!is_null($this->getSceneId())) {
            $scene['scene_id'] = (int)$this->getSceneId();
        }

        if (!is_null($this->getSceneStr())) {
            $scene['scene_str'] = (string)$this->getSceneStr();
        }

        $this->action_info = [
            'scene' => $scene
        ];

        return parent::toArray($columns);
    }
}