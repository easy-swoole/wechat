<?php


namespace EasySwoole\WeChat\Bean\MiniProgram;

use EasySwoole\Spl\SplBean;

class AddOrder extends SplBean
{
    /** @var int */
    protected $addSource;
    /** @var string */
    protected $wxAppid;
    /** @var string */
    protected $expectTime;
    /** @var string */
    protected $orderId;
    /** @var string */
    protected $openid;
    /** @var string */
    protected $deliveryId;
    /** @var string */
    protected $bizId;
    /** @var string */
    protected $customRemark;
    /** @var int */
    protected $tagid;
    /** @var object */
    protected $sender;
    /** @var object */
    protected $receiver;
    /** @var object */
    protected $cargo;
    /** @var object */
    protected $shop;
    /** @var object */
    protected $insured;
    /** @var object */
    protected $service;

    /**
     * @return int
     */
    public function getAddSource(): int
    {
        return $this->addSource;
    }

    /**
     * @param int $addSource
     */
    public function setAddSource(int $addSource): void
    {
        $this->addSource = $addSource;
    }

    /**
     * @return string
     */
    public function getWxAppid(): string
    {
        return $this->wxAppid;
    }

    /**
     * @param string $wxAppid
     */
    public function setWxAppid(string $wxAppid): void
    {
        $this->wxAppid = $wxAppid;
    }

    /**
     * @return string
     */
    public function getExpectTime(): string
    {
        return $this->expectTime;
    }

    /**
     * @param string $expectTime
     */
    public function setExpectTime(string $expectTime): void
    {
        $this->expectTime = $expectTime;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOpenid(): string
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid(string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    /**
     * @param string $deliveryId
     */
    public function setDeliveryId(string $deliveryId): void
    {
        $this->deliveryId = $deliveryId;
    }

    /**
     * @return string
     */
    public function getBizId(): string
    {
        return $this->bizId;
    }

    /**
     * @param string $bizId
     */
    public function setBizId(string $bizId): void
    {
        $this->bizId = $bizId;
    }

    /**
     * @return string
     */
    public function getCustomRemark(): string
    {
        return $this->customRemark;
    }

    /**
     * @param string $customRemark
     */
    public function setCustomRemark(string $customRemark): void
    {
        $this->customRemark = $customRemark;
    }

    /**
     * @return int
     */
    public function getTagid(): int
    {
        return $this->tagid;
    }

    /**
     * @param int $tagid
     */
    public function setTagid(int $tagid): void
    {
        $this->tagid = $tagid;
    }

    /**
     * @return object
     */
    public function getSender(): object
    {
        return $this->sender;
    }

    /**
     * @param object $sender
     */
    public function setSender(object $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return object
     */
    public function getReceiver(): object
    {
        return $this->receiver;
    }

    /**
     * @param object $receiver
     */
    public function setReceiver(object $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return object
     */
    public function getCargo(): object
    {
        return $this->cargo;
    }

    /**
     * @param object $cargo
     */
    public function setCargo(object $cargo): void
    {
        $this->cargo = $cargo;
    }

    /**
     * @return object
     */
    public function getShop(): object
    {
        return $this->shop;
    }

    /**
     * @param object $shop
     */
    public function setShop(object $shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @return object
     */
    public function getInsured(): object
    {
        return $this->insured;
    }

    /**
     * @param object $insured
     */
    public function setInsured(object $insured): void
    {
        $this->insured = $insured;
    }

    /**
     * @return object
     */
    public function getService(): object
    {
        return $this->service;
    }

    /**
     * @param object $service
     */
    public function setService(object $service): void
    {
        $this->service = $service;
    }


}
