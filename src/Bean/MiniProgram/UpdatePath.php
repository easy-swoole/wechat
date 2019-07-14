<?php


namespace EasySwoole\WeChat\Bean\MiniProgram;

use EasySwoole\Spl\SplBean;

class UpdatePath extends SplBean
{
    /** @var string */
    protected $token;
    /** @var string */
    protected $waybillId;
    /** @var int */
    protected $actionTime;
    /** @var int */
    protected $actionType;
    /** @var string */
    protected $actionMsg;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getWaybillId(): string
    {
        return $this->waybillId;
    }

    /**
     * @param string $waybillId
     */
    public function setWaybillId(string $waybillId): void
    {
        $this->waybillId = $waybillId;
    }

    /**
     * @return int
     */
    public function getActionTime(): int
    {
        return $this->actionTime;
    }

    /**
     * @param int $actionTime
     */
    public function setActionTime(int $actionTime): void
    {
        $this->actionTime = $actionTime;
    }

    /**
     * @return int
     */
    public function getActionType(): int
    {
        return $this->actionType;
    }

    /**
     * @param int $actionType
     */
    public function setActionType(int $actionType): void
    {
        $this->actionType = $actionType;
    }

    /**
     * @return string
     */
    public function getActionMsg(): string
    {
        return $this->actionMsg;
    }

    /**
     * @param string $actionMsg
     */
    public function setActionMsg(string $actionMsg): void
    {
        $this->actionMsg = $actionMsg;
    }


}